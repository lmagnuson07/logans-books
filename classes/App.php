<?php

namespace App;

use App\Config\Config;
use App\Config\Twig;
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use App\Exceptions\RouteNotFoundException;
use Dotenv\Dotenv;
use Exception;
use PDOException;

class App
{
	private static ?DB $db = null;
	protected Router $router;
	protected Config $config;
	protected array $request;
	static public string $staticView;
	static public bool $hasStaticView = false;
	public string $view;
	public bool $hasView = false;

	public function __construct(array $request, Config $config) {
		$this->request = $request;
		$this->config = $config;
		$this->dbInit();
	}

	/**
	 * Getter to access the Apps static db instance.
	 *
	 * @return DB
	 */
	static public function db(): DB {
		return static::$db;
	}

	static public function disconn(): void {
		if (isset(static::$db)) {
			static::$db = null;
		}
	}

	public function run():void {
		try {
			$this->view = $this->router->resolve(
				$this->request['uri'],
				strtolower($this->request['method'])
			);
			$this->hasView = true;
		} catch(RouteNotFoundException $ex) {
			http_response_code(404);

			$this->view =  View::make('errors/404');
			$this->hasView = true;
		}
	}

	static public function initConsts($csvPath): void {
		define("PROJECT_PATH", dirname(__DIR__));
		define("PRIVATE_PATH", PROJECT_PATH . '/private');
		define("PUBLIC_PATH", PROJECT_PATH . '/public');
		define('CSV_DOCUMENT_PATH', $csvPath);

		// doc root is htdocs
		//$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
		//$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);

		// doc root is public folder
		$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, 0);
		define("WWW_ROOT", $doc_root);
	}

	static public function setDependencies(): void {
		// Loads environment variables from .env to the $_ENV superglobal
		$dotenv = Dotenv::createImmutable(dirname(__DIR__));
		$dotenv->load();

		// Setup for twig
		try {
			Twig::init();
			Twig::initFilters();
		} catch (Exception $ex) {
			static::$staticView =  View::make('errors/404');
			static::$hasStaticView = true;
		}
	}

	private function dbInit(): void {
		try {
			static::$db = new DB($this->config->db ?? []);
		} catch (PDOException $e) {
			static::$staticView = View::make('errors/dberror');
			static::$hasStaticView = true;
		} catch (Exception $e) {
			// Catching default exception. No need to show error page.
			static::$staticView =  View::make('errors/404');
			static::$hasStaticView = true;
		}
	}

	public function mainRouter(Router $router): void {
		$this->router = $router;
		$this->router
			->get('/',[HomeController::class, 'index'])
			->get('/invoices', [InvoiceController::class, 'index'])
			->get('/invoices/create', [InvoiceController::class, 'create'])
			->post('/invoices/create', [InvoiceController::class, 'store']);
	}
}