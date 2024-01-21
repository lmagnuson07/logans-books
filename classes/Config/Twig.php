<?php

namespace App\Config;
use App\Exceptions\ViewNotFoundException;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class Twig
{
	const VIEW_PATH = __DIR__ . '/../../views/';
	static protected array $page_dict = [];
	static protected FilesystemLoader $loader;
	static protected Environment $twig;

	/**
	 * @throws ViewNotFoundException
	 */
	static public function init(): void {
		if (!is_dir(self::VIEW_PATH)){
			throw new ViewNotFoundException();
		}
		self::$loader = new FilesystemLoader(self::VIEW_PATH);
		self::$twig = new Environment(self::$loader, [
			'debug' => true,
			// 'cache' => PROJECT_PATH . '\storage\cache',
		]);
		static::pageDictInit();
	}

	static private function pageDictInit(): void {
		static::$page_dict = [
			"contentServerUrl" => CONTENT_SERVER,
		];
	}

	static public function initFilters():void {
		self::$twig->addExtension(new DebugExtension());
	}
}