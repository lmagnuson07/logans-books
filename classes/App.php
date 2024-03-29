<?php

namespace App;

use App\Config\Config;
use App\Config\Twig;
use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\ImportsController;
use App\Controllers\HomeController;
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
		$this->request['uri'] = $this->resolveRoute($request['uri']);

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

			$this->view = View::make('errors/404');
			$this->hasView = true;
		}
	}

	static public function initConsts(): void {
		define("PROJECT_PATH", dirname(__DIR__));
		define("PRIVATE_PATH", PROJECT_PATH . '\\private\\');
		define("PUBLIC_PATH", PROJECT_PATH . '\\public\\');
		define("UPLOADS_PATH", PROJECT_PATH . '\\uploads\\');
		define("DATA_FILES_PATH", PROJECT_PATH . '\\data-files\\');
		define("UNECE_PATH", DATA_FILES_PATH . '\\unece\\');
		define("SQL_SCRIPTS_PATH", PROJECT_PATH . '\\database_scripts\\');

		define("WWW", 'http://logans-books.local');
		define("CONTENT_SERVER", 'http://logans-books-assets.local');

		define('DEFAULT_TIMEZONE', 'America/Edmonton');
	}

	static public function setDependencies(): void {
		// Loads environment variables from .env to the $_ENV superglobal
		$dotenv = Dotenv::createImmutable(dirname(__DIR__));
		$dotenv->load();

		try {
			// Setup for twig
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
            ///////////////////////////////////////////////////////////////////
            /// Public routes
			->get('/',[HomeController::class, 'index'])
//			->get('/invoices', [InvoiceController::class, 'index'])
//			->get('/invoices/create', [InvoiceController::class, 'create'])
//			->post('/invoices/create', [InvoiceController::class, 'store'])
            ///////////////////////////////////////////////////////////////////
            /// Admin routes
            ->get('/admin', [AdminController::class, 'index'])
			->get('/admin/imports', [ImportsController::class, 'index'])
			->post('/admin/imports', [ImportsController::class, 'postHandler'])
        ;
	}

    private function resolveRoute(string $route): string {
        if (str_ends_with($route, '/')) {
            if (strlen($route) == 1) {
                return $route;
            }
            return substr($route, 0, strlen($route) - 1);
        }
        return $route;
    }
}