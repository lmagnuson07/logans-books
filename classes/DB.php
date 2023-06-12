<?php

namespace App;

use PDO;
use PDOException;

/**
 * @mixin PDO
 */
class DB
{
	private PDO $pdo;

	// FETCH_ASSOC, FETCH_CLASS, default fetch array
	private array $defaultOptions = [
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		PDO::ATTR_EMULATE_PREPARES => false,
	];

	public function __construct(array $env) {
		if (!isset($this->pdo)) {
			try {
				// TODO: Create a class that will read the ENV superglobal and cache the values in it. See Programming with gio PHP PDO tutorial part 2
				$this->pdo = new PDO(
					$env['db_driver'] . ':dbname=' . $env['db_name'] . ';host='. $env['db_server'] . ';port:' .  $env['db_port'],
					$env['db_user'],
					$env['db_pass'],
					$env['options'] ?? $this->defaultOptions
				);
			} catch (PDOException $ex) {
				throw new PDOException($ex->getMessage(), (int) $ex->getCode());
			}
		}
	}

	/**
	 * Proxies function calls to the PDO instance.
	 * This magic method gets called when a method that doesn't exist on this class is called.
	 *
	 * Added a mixin tag to the DB phpdoc so phpstorm knows we are proxying calls to the PDO class.
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return void
	 */
	public function __call(string $name, array $arguments) {
		return call_user_func_array([$this->pdo, $name], $arguments);
	}

}