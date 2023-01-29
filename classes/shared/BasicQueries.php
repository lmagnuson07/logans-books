<?php
/*
 * This class is for basic query functions that won't be inherited by entities.
 * Also used to collect data from bridging tables to avoid creating unnecessary classes for the bridging tables.
*/

namespace App\Shared;
use PDO;

class BasicQueries extends DBObj
{
	///////////////// Queries /////////////////////////////////////
	static public function fetchBySql(string $sql, int $id): \stdClass {
		$stmt = self::$db->prepare($sql);

		$stmt->execute([$id]);
		$result = $stmt->fetch();
		$stmt->closeCursor();

		return $result;
	}
	static public function fetchAllBySql(string $sql, int $id=null): array {
		$stmt = self::$db->prepare($sql);

		if (empty($id)) {
			$stmt->execute();
		} else {
			$stmt->execute([$id]); // For bridging tables.
		}
		$result = $stmt->fetchAll();
		$stmt->closeCursor();

		return $result;
	}
	static public function fetchColsById(array $cols, int $id, string $tableName): \stdClass {
		$sql = "SELECT " . join(',', array_values($cols))
			. " FROM " . $tableName
			. " WHERE id = ?";

		return static::fetchBySql($sql, $id);
	}
	static public function fetchBridgingTableColsById(array $cols, int $id, string $tableName, string $targetId): array {
		$sql = "SELECT " . join(',', array_values($cols))
			. " FROM " . $tableName
			. " WHERE " . $targetId . " = ?";

		return static::fetchAllBySql($sql, $id);
	}
	///////////////// Inserts /////////////////////////////////////
	static public function insertCols(array $cols, string $placeHolders, string $tableName, array $insertData): void {
		$stmt = self::$db->prepare(
			"INSERT INTO " . $tableName . " (" . join(',', array_values($cols)) . ") " .
							"VALUES $placeHolders"
		);
		$stmt->execute($insertData);
//		$stmt->closeCursor();
	}
	///////////////// Deletes /////////////////////////////////////
	static public function deleteRecords(string $placeHolders, string $tableName, array $ids): void {
		$stmt = self::$db->prepare(
			"DELETE FROM $tableName WHERE id IN ($placeHolders)"
		);
		$stmt->execute($ids);
	}
}