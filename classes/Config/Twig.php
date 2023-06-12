<?php

namespace App\Config;
use App\Exceptions\ViewNotFoundException;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
	const VIEW_PATH = __DIR__ . '/../../views/';
	protected array $page_dict = [];
	static protected FilesystemLoader $loader;
	static protected Environment $twig;

	public function __construct($page_dict=[]) {
		$this->page_dict = $page_dict;
	}

	/**
	 * @throws ViewNotFoundException
	 */
	static public function init(): void {
		if (!is_dir(self::VIEW_PATH)){
			throw new ViewNotFoundException();
		}
		self::$loader = new FilesystemLoader(self::VIEW_PATH);
		self::$twig = new Environment(self::$loader, [
			// 'cache' => PROJECT_PATH . '\storage\cache',
		]);
	}

	public function getPageDict(): array {
		return $this->page_dict;
	}

	public function addVar(string $key, mixed $data): void {
		$this->page_dict[$key] = $data;
	}

	static public function initFilters():void {

	}
}