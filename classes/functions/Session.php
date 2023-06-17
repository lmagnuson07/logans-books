<?php
/**
 * This file contains the class for interacting with the $_SESSION suberglobal.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since 		1.0
 * @version		1.0
 * @license 	http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 */

namespace App\Functions;

/**
 * Contains static functions for interacting with the $_SESSION suberglobal.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since		1.0
 * @version		1.0
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 */
class Session
{
	/**
	 * Sets a single session variable.
	 *
	 * @param string|null $key
	 * @param mixed|null $value
	 * @return void
	 */
	static public function setSession(string|null $key=null, mixed $value=null): void {
		if (!empty($key) && isset($value)) {
			$_SESSION[$key] = $value;
		}
	}

	/**
	 * Sets multiple session variables at once. Must pass a key => value array.
	 *
	 * @param array|null $keys
	 * @return void
	 */
	static public function setSessions(array|null $keys=null): void {
		if (!empty($key)) {
			foreach ($keys as $key => $value) {
				$_SESSION[$key] = $value;
			}
		}
	}

	/**
	 * Unset a single session variable.
	 *
	 * @param string|null $key
	 * @return void
	 */
	static public function unsetSession(string|null $key=null): void {
		if (!empty($key)) {
			unset($_SESSION[$key]);
		}
	}

	/**
	 * Unset multiple session variables at once. Must pass an indexed array.
	 *
	 * @param array|null $keys
	 * @return void
	 */
	static public function unsetSessions(array|null $keys=null): void {
		if (!empty($keys)) {
			foreach ($keys as $key) {
				unset($_SESSION[$key]);
			}
		}
	}

	/**
	 * Wipes all session data and regenerates the session ID.
	 *
	 * @return void
	 */
	static public function wipeSession():void {
		session_unset();         // Clear all session variables
		session_destroy();       // Destroy the session

		// To prevent session fixation attacks. Makes it difficult for an attacker to hijack a session
		session_regenerate_id(true); // Regenerate the session ID
	}
}