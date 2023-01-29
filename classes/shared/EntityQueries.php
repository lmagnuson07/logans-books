<?php

namespace App\Shared;
use App\Functions\HelperFunctions;
use PDO;

class EntityQueries extends DBObj
{
	///////////////// Shared /////////////////////////////////////
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
						$stmt->bindValue(":$k", HelperFunctions::h((int)$v));
					} else {
						$stmt->bindValue(":$k", HelperFunctions::h($v));
					}
				}
			}
			elseif (!in_array($k, $ignoreList)) {
				$stmt->bindValue(":$k", HelperFunctions::h($v));
			}
		}
		$stmt->execute();
	}
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






