<?php
/**
 * This file contains the EntityQueries class that contains functions that perform queries or other tasks shared by all entity classes.
 *
 * This class is intended to be inherited by all entity classes.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since		1.0
 * @version		1.0
 * @license 	http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 * @Created 	2023-07-12
 */

namespace App\Routines;

use App\DB;

/**
 * Contains methods shared by all entities that perform queries and other functionality.
 *
 * This class is designed to be inherited by Entity classes.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since		1.0
 * @version		1.0
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 * @Created 	2023-07-12
 * @Updated		2023-07-12
 */
class EntityQueries
{
	/**
	 * Static dependency for the database connection.
	 * DB is a custom class that initializes the PDO connection and proxies function calls to the PDO class.
	 *
	 * @var DB
	 */
	static protected DB $db;

	/**
	 * Acts as a constructor for the static methods of the class, setting the required static properties.
	 *
	 * @param DB $db
	 * @return void
	 */
	public static function init(DB $db): void {
		self::$db = $db;
	}

	///////////////// Shared /////////////////////////////////////
	/**
	 * Loops through all properties ($this) of the Entity class and returns them in an array to be used in entity queries.
	 * Can pass an optional "Ignore List" array of strings to omit certain properties (like arrays).
	 *
	 * Assumes your Entity properties are mapped to the database column names.
	 *
	 * @param array $ignoreList [Optional]
	 * Database column names mapped to entity properties to be ignored.
	 * @return array
	 */
	public function getClassCols(array $ignoreList=[]): array {
		$cols = [];
		foreach($this as $k=>$v) {
			if (!empty($ignoreList)) {
				if (!in_array($k, $ignoreList)) {
					$cols[] = $k;
				}
			} else {
				$cols[] = $k;
			}
		}
		return $cols;
	}

	public function performInstanceDML(string $sql, array $ignoreList=[], $convert=[]) {
		$stmt = static::$db->prepare($sql);

		foreach ($this as $k=>$v) {
			if (!empty($convert) && $convert['convert_bool']) {
				if (!in_array($k, $ignoreList)) {
					if ($k == $convert['convert_item']) {
						$stmt->bindValue(":$k", (int)$v);
					} else {
						$stmt->bindValue(":$k", $v);
					}
				}
			}
			elseif (!in_array($k, $ignoreList)) {
				$stmt->bindValue(":$k", $v);
			}
		}
		$stmt->execute();
	}
	///////////////// PDO Statements /////////////////////////////////////
	static public function fetchAllBySql(string $sql, int $id): array {
		$stmt = self::$db->prepare($sql);

		$stmt->execute([$id]);
		$result = $stmt->fetchAll();
		$stmt->closeCursor();

		return $result;
	}
	static public function fetchBySqlEntity(string $sql, int $id): object {
		$stmt = self::$db->prepare($sql);
		$stmt->setFetchMode(self::$db::FETCH_CLASS, static::class);

		$stmt->execute([$id]);
		$result = $stmt->fetch(self::$db::FETCH_CLASS);
		$stmt->closeCursor();

		return $result;
	}
	static public function fetchAllBySqlEntity(string $sql): array {
		$stmt = self::$db->prepare($sql);

		$stmt->execute();
		$result = $stmt->fetchAll(self::$db::FETCH_CLASS, static::class);
		$stmt->closeCursor();

		return $result;
	}
	///////////////// Queries /////////////////////////////////////
	static public function fetchAll(): array {
		self::setTableName();

		$sql = "SELECT * FROM " . self::$tableName;
		return static::fetchAllBySqlEntity($sql);
	}
	static public function fetchCols(array $cols, array $orderBy=[]): array {
		self::setTableName();

		$sql = "SELECT " . join(',', array_values($cols))
			. " FROM " . self::$tableName;
		if (!empty($orderBy)) {
			$sql .= " ORDER BY " . join(',', array_values($orderBy));
		}
		return static::fetchAllBySqlEntity($sql);
	}
	static public function fetchColsById(array $cols, int $id): object {
		self::setTableName();

		$sql = "SELECT " . join(',', array_values($cols))
			. " FROM " . self::$tableName
			. " WHERE id = ?";

		return static::fetchBySqlEntity($sql, $id);
	}
	///////////////// Inserts /////////////////////////////////////
	static public function insertCols(array $cols, string $values): void {

	}
}