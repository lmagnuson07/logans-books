<?php

namespace App\Shared;
use PDO;

class DBObj
{
	static protected $db;
	static protected string $tableName = "";
	protected static function setTableName(string $tablePrefix = ""): void {
		$className = explode("\\",static::class);
		self::$tableName = strtolower($className[count($className)-1] . $tablePrefix);
	}
	/////////////// Connection /////////////////////////////////////
	static public function conn() {
		if (!self::$db) {
			// FETCH_ASSOC, FETCH_CLASS, default fetch array
			// TODO: Create a class that will read the ENV superglobal and cache the values in it. See Programming with gio PHP PDO tutorial part 2
			$conn = new PDO($_ENV['DB_DRIVER'] . ':dbname=' . $_ENV['DB_NAME'] . ';host='. $_ENV['DB_SERVER'] . ';port:' .  $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASS'], [
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
				PDO::ATTR_EMULATE_PREPARES => false, // performance boost. placeholders in other clauses (limit). Returns int not string.
			]);
			return self::$db = $conn;
		} else {
			return self::$db;
		}
	}
	static public function disconn(): void {
		if (isset(self::$db)) {
			self::$db = null;
		}
	}
}






