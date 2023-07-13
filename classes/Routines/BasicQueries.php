<?php
/**
 * This file contains the BasicQueries class that contains reusable methods for querying the database.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since 		1.0
 * @version		1.0
 * @license 	http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 * @Created 	2023-07-01
 */
namespace App\Routines;

use App\DB;
use App\Exceptions\DataInsertException;
use App\Exceptions\ParameterExceptions\EmptyParameterException;
use App\Exceptions\ParameterExceptions\InvalidArgumentException;

/**
 * Contains static, reusable functions for querying the database.
 * The database connection is implemented through dependency injection.
 *
 * Exceptions are not caught in this class and must be handled wherever the methods are called.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since		1.0
 * @version		1.0
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 * @Created		2023-07-01
 * @Updated		2023-07-01
 */
class BasicQueries
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

	/////////////////////////////////////////////////////////////
	/// Select methods
	static public function selectAllFromTable(string $tableName): array {
		$stmt = self::$db->query("SELECT * FROM $tableName");
		$stmt->setFetchMode(self::$db::FETCH_ASSOC);
		return $stmt->fetchAll();
	}

	/////////////////////////////////////////////////////////////
	/// Insert methods
	/**
	 *
	 * @param array $data
	 * @param string $tableName
	 * @return void
	 * @throws DataInsertException|EmptyParameterException|InvalidArgumentException
	 */
	static public function insertKeyValues(array $data, string $tableName): void {
		if (empty($data)) {
			throw new EmptyParameterException();
		}
		// Make the data an array of arrays if a one dimensional array is passed.
		if (!is_array($data[0])) {
			$temp = $data;
			$data = [];
			$data[] = $temp;
		}

		// Sort the inner arrays alphabetically by their keys.
		$sortedData = array_map(function ($array) {
			ksort($array);
			return $array;
		}, $data);

		///////////////// Inserts /////////////////////////////////////
		// Get the row names for the INSERT (keys of first row))
		$cols = array_keys($sortedData[0]);

		$rowCount = count($sortedData[0]);
		$recordCount = count($sortedData);

		if (!static::innerArraysAreOfSize($sortedData, $rowCount)) {
			throw new InvalidArgumentException();
		}

		// Store a placeholder for each data.
		$placeHolders = "(" .
			implode('),(',
				array_fill(0, $recordCount,
					implode(',',
						array_fill(0, $rowCount, "?")
					)
				)
			)
		. ")";

		// Stage data (values from data array need to be inserted into an indexed array).
		$insertData = array_reduce($sortedData, function ($carry, $innerArray) {
			return array_merge($carry, array_values($innerArray));
		}, []);

		self::$db->beginTransaction();

		$stmt = self::$db->prepare(
			"INSERT INTO " . $tableName . " (" . join(',', array_values($cols)) . ") " .
			"VALUES $placeHolders"
		);
		$result = $stmt->execute($insertData);

		if ($result) {
			self::$db->commit();
		} else {
			self::$db->rollBack();
			throw new DataInsertException();
		}

	}

	/////////////////////////////////////////////////////////////////
	/// Delete methods


	/////////////////////////////////////////////////////////////////
	/// Counts
	static public function countTableRecords(string $tableName): int {
		$stmt = self::$db->query("SELECT COUNT(*) FROM $tableName");
		return $stmt->fetchColumn();
	}

	/////////////////////////////////////////////////////////////////
	/// Private helper methods
	static private function innerArraysAreOfSize(array $array, int $size): bool {
		foreach ($array as $innerArray) {
			if (count($innerArray) !== $size) {
				return false;
			}
		}
		return true;
	}
}