<?php
/**
 * This file contains the class for interacting with the $_POST suberglobal.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since 		1.0
 * @version		1.0
 * @license 	http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 */

namespace App\Superglobals;

/**
 * Contains static functions for interacting with the $_POST suberglobal.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since		1.0
 * @version		1.0
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 */
class Post {
	static private array $postArray;

	/**
	 * Initialize the $postArray static property through dependency injection.
	 *
	 * @param array $postArray
	 * @return void
	 */
	static public function initPostArray(array $postArray): void {
		static::$postArray = $postArray;
	}

	/**
	 * Returns the static $postArray property.
	 *
	 * @return array
	 */
	static public function getPostArray(): array {
		return static::$postArray;
	}

	/**
	 * Returns a reference to the $_POST superglobal.
	 *
	 * @return array
	 */
	static public function getRawPostArray(): array {
		return $_POST;
	}

	/**
	 * Checks if key exists in the static $postArray property.
	 *
	 * @param string $key
	 * @return bool
	 */
	static public function hasKey(string $key): bool {
		return isset(static::$postArray[$key]);
	}

	/**
	 * Gets a single value from the static $postArray property.
	 *
	 * @param string $key
	 * @return mixed|null
	 */
	static public function getValue(string $key): array|null {
		return static::$postArray[$key] ?? null;
	}

	/**
	 * Returns a filtered array of values from the static $postArray property.
	 * Must pass an indexed array of strings to search for.
	 *
	 * @param array $keys
	 * @return array
	 */
	static public function getValues(array $keys): array {
		$filteredPostArray = [];
		foreach($keys as $key) {
			if (key_exists($key, static::$postArray)) {
				$filteredPostArray[$key] = static::$postArray[$key];
			} else {
				$filteredPostArray[$key] = 'NotFound';
			}
		}
		return $filteredPostArray;
	}
}