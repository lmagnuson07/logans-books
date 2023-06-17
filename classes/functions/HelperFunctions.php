<?php

namespace App\Functions;
use JetBrains\PhpStorm\NoReturn;

class HelperFunctions
{
	public static function url_for($script_path): string {
		if($script_path[0] != '/') {
			$script_path = "/" . $script_path;
		}
		return WWW_ROOT . $script_path;
	}
	public static function u($string=""): string {
		return urlencode($string);
	}
	public static function raw_u($string=""): string {
		return rawurlencode($string);
	}
	public static function h($string=""): string {
		return htmlspecialchars($string);
	}
	public static function title_text($str): string {
		$result = preg_replace("/[\-_.]/", " ", $str);
		return ucfirst($result);
	}
	#[NoReturn] public static function redirect_to($location): void {
		header("Location: " . $location);
		exit;
	}
	public static function add_to_array_if_unique(array &$arr, string $key, int|string $value=null):void {
		if(!empty($arr[$key])) {
			if (!in_array($value, $arr[$key])) {
				$arr[$key][] = $value;
			}
		} elseif(isset($value)) {
			$arr[$key][] = $value;
		}
	}
}