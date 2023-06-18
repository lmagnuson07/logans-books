<?php
/**
 * This file contains the class for interacting with the $_GET suberglobal.
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
 * Contains static functions for interacting with the $_GET suberglobal.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since		1.0
 * @version		1.0
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 */
class Get
{
	static private array $getArray;

	/**
	 * Initialize the $getArray static property through dependency injection.
	 *
	 * @param array $getArray
	 * @return void
	 */
	static public function initGetArray(array $getArray): void {
		static::$getArray = $getArray;
	}

	/**
	 * Returns the static $getArray property.
	 *
	 * @return array
	 */
	static public function getGetArray(): array {
		return static::$getArray;
	}

	/**
	 *  Returns a reference to the $_GET superglobal.
	 *
	 * @return array
	 */
	static public function getRawGetArray(): array {
		return $_GET;
	}

	/**
	 * Checks if key exists in the static $getArray property.
	 *
	 * @param string $key
	 * @return bool
	 */
	static public function hasKey(string $key): bool {
		return isset(static::$getArray[$key]);
	}

	/**
	 * Gets a single value from the static $getArray property.
	 *
	 * @param string $key
	 * @return array|null
	 */
	static public function getValue(string $key): array|null {
		return static::$getArray[$key];
	}

	/**
	 * Returns a filtered array of values from the static $getArray property.
	 * Must pass an indexed array of strings to search for.
	 *
	 * @param array $keys
	 * @return array
	 */
	static public function getValues(array $keys): array {
		$filteredGetArray = [];
		foreach($keys as $key) {
			if (key_exists($key, static::$getArray)) {
				$filteredGetArray[$key] = static::$getArray[$key];
			} else {
				$filteredGetArray[$key] = 'NotFound';
			}
		}
		return $filteredGetArray;
	}
}