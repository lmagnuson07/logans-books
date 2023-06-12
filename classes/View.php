<?php

namespace App;

use App\Config\Twig;
use App\Exceptions\ViewNotFoundException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class View extends Twig
{
	private static string $view;
	private static array $pageDictInit;
	private static array $params;

	/**
	 * We already know that the View Path has been validated in the init.
	 *
	 * @param string $view
	 * @param array $pageDictInit
	 * @param array $params
	 * @return static
	 */
	static public function make(string $view, array $pageDictInit=[], array $params=[]):static {
		self::$view = $view . '.html.twig';
		self::$pageDictInit = $pageDictInit;
		self::$params = $params;

		return new static;
	}
	public function render(): string {
		$twig = new Twig(self::$pageDictInit);
		try {
			if (!file_exists(self::VIEW_PATH . static::$view)) {
				throw new ViewNotFoundException();
			}
			return self::$twig->render(static::$view, $twig->page_dict);
		} catch (LoaderError $ex) {
			return 'Loader Error';
		} catch (RuntimeError $ex) {
			return 'Runtime Error';
		} catch (SyntaxError $ex) {
			return 'Syntax Error';
		} catch (ViewNotFoundException $ex) {
			return $ex->getMessage();
		}
	}

	public function __toString(): string {
		return $this->render();
	}
}