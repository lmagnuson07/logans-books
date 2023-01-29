<?php

namespace App\Shared;
use PDO;

class EntityQueries extends DBObj
{
	///////////////// PDO Statements /////////////////////////////////////
	static public function fetchAllBySql(string $sql, int $id): array {
		$stmt = self::$db->prepare($sql);

		$stmt->execute([$id]);
		$result = $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
		$stmt->closeCursor();

		return $result;
	}
	static public function fetchBySqlEntity(string $sql, int $id): object {
		$stmt = self::$db->prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_CLASS, static::class);

		$stmt->execute([$id]);
		$result = $stmt->fetch(PDO::FETCH_CLASS);
		$stmt->closeCursor();

		return $result;
	}
	static public function fetchAllBySqlEntity(string $sql): array {
		$stmt = self::$db->prepare($sql);

		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
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






