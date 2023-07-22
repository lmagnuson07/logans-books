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

namespace App\Repositories;

use App\DB;
use App\Exceptions\DatabaseExceptions\DMLException;
use App\Exceptions\DatabaseExceptions\FetchRecordException;

/**
 * Contains static and instance methods shared by all entities that perform queries and other functionality.
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
	 * The databases table name. Should match the entity name, minus the prefix and/or suffix.
	 *
	 * @var string
	 */
	protected string $tableName;

	protected string $entityClassName;

	/**
	 * Static dependency for the database connection.
	 * DB is a custom class that initializes the PDO connection and proxies function calls to the PDO class.
	 *
	 * @var DB
	 */
	protected DB $db;

	public function __construct(DB $db, string $entityClassName) {
		$this->db = $db;
		$this->setTableName();
		$this->entityClassName = $entityClassName;
	}

	///////////////// Shared /////////////////////////////////////
	/**
	 * Sets the $tableName property from the EntityRepository class name.
	 *
	 * Assumes your database tables names are lowercase (uses strtolower) and that your repository class is in the format: entityRepository.
	 *
	 * @param string $tablePrefix [Optional]
	 * @param string $tableSuffix [Optional]
	 * @return void
	 */
	protected function setTableName(string $tablePrefix="", string $tableSuffix=""): void {
		$className = explode("\\",static::class);
		$className = str_replace("Repository", "", $className[count($className)-1]);
		$this->tableName = strtolower($tablePrefix . $className . $tableSuffix);
	}

	/**
	 * Performs database manipulation language on the database.
	 * Intended to be used in entity class that inherits EntityQueries.
	 * Create the sql query in the entity and pass it to the method.
	 *
	 * @param string $sql
	 * @param array $ignoreList [Optional]
	 * Database column names mapped to entity properties to be ignored.
	 * @return void
	 * @throws DMLException
	 */
	public function performInstanceDML(string $sql, array $ignoreList=[]) {
		$this->db->beginTransaction();

		$stmt = $this->db->prepare($sql);

		foreach ($this as $k=>$v) {
//			if (!empty($convert) && $convert['convert_bool']) {
//				if (!in_array($k, $ignoreList)) {
//					if ($k == $convert['convert_item']) {
//						$stmt->bindValue(":$k", (int)$v);
//					} else {
//						$stmt->bindValue(":$k", $v);
//					}
//				}
//			}
			if (!in_array($k, $ignoreList)) {
				$stmt->bindValue(":$k", $v);
			} elseif (!in_array($k, $ignoreList)) {
				$stmt->bindValue(":$k", $v);
			}
		}
		$result = $stmt->execute();

		if ($result) {
			$this->db->commit();
		} else {
			$this->db->rollBack();
			throw new DMLException();
		}
	}

	///////////////// PDO Statements /////////////////////////////////////
	/**
	 * Meant to be used in Entity classes that inherit the EntityQueries class.
	 * Fetches a single record by the id parameter using the default fetch method.
	 *
	 * @param string $sql
	 * @param int $id
	 * @return array
	 * @throws FetchRecordException
	 */
	public function fetchRecordBySql(string $sql, int $id): array {
		$stmt = $this->db->prepare($sql);

		$result = $stmt->execute([$id]);

		if (!$result) {
			$stmt->closeCursor();
			throw new FetchRecordException();
		}

		$result = $stmt->fetchAll();
		$stmt->closeCursor();

		return $result;
	}

	/**
	 * Meant to be used in Entity classes that inherit the EntityQueries class.
	 * Fetches a single entity record by the id parameter using the default PDO FETCH_OBJ and the Entities constructor.
	 *
	 * @param string $sql
	 * @param int $id
	 * @return object
	 * @throws FetchRecordException
	 */
	public function fetchBySqlEntity(string $sql, int $id): object {
		$stmt = $this->db->prepare($sql);

		$result = $stmt->execute([$id]);

		if (!$result) {
			$stmt->closeCursor();
			throw new FetchRecordException();
		}

		$result = $stmt->fetch();
		$stmt->closeCursor();

		return new $this->entityClassName($result);
	}

	/**
	 * Meant to be used in Entity classes that inherit the EntityQueries class.
	 * Fetches all entity records using the default PDO FETCH_OBJ and the Entities constructor with the SQL passed to the method.
	 * Same as EntityQueries::fetchBySqlEntity() but without an ID placeholder.
	 *
	 * @param string $sql
	 * @return array
	 * @throws FetchRecordException
	 */
	public function fetchAllBySqlEntity(string $sql): array {
		$stmt = $this->db->prepare($sql);

		$result = $stmt->execute();

		if (!$result) {
			$stmt->closeCursor();
			throw new FetchRecordException();
		}

		$result = $stmt->fetchAll();
		$stmt->closeCursor();

		$objArr = [];
		foreach ($result as $obj) {
			$objArr[] = new $this->entityClassName($obj);
		}

		return $objArr;
	}
	///////////////// Queries /////////////////////////////////////

	/**
	 * Meant to be used in Entity classes that inherit the EntityQueries class.
	 * Fetch all records and fields for the Entity using the wildcard operator.
	 * Uses EntityQueries::fetchAllBySqlEntity().
	 *
	 * @return array
	 * @throws FetchRecordException
	 */
	public function fetchAll(): array {
		$sql = "SELECT * FROM " . $this->tableName;
		return static::fetchAllBySqlEntity($sql);
	}

	/**
	 * Meant to be used in Entity classes that inherit the EntityQueries class.
	 * Fetch all records and the selected fields passed to the method for the Entity.
	 * Uses EntityQueries::fetchAllBySqlEntity().
	 *
	 * Use the result of EntityQueries::getClassCols() for the $cols parameter.
	 *
	 * @param array $cols
	 * @param array $orderBy [Optional]
	 * @return array
	 * @throws FetchRecordException
	 */
	public function fetchAllByCols(array $cols, array $orderBy=[]): array {
		$sql = "SELECT " . join(',', array_values($cols))
			. " FROM " . $this->tableName;
		if (!empty($orderBy)) {
			$sql .= " ORDER BY " . join(',', array_values($orderBy));
		}
		return static::fetchAllBySqlEntity($sql);
	}

	/**
	 * Meant to be used in Entity classes that inherit the EntityQueries class.
	 * Fetch a single record and the selected fields passed to the method for the Entity.
	 * Uses EntityQueries::fetchBySqlEntity().
	 *
	 * Use the result of EntityQueries::getClassCols() for the $cols parameter.
	 *
	 * @param array $cols
	 * @param int $id
	 * @return object
	 * @throws FetchRecordException
	 */
	public function fetchByColsById(array $cols, int $id): object {
		$sql = "SELECT " . join(',', array_values($cols))
			. " FROM " . $this->tableName
			. " WHERE id = ?";

		return static::fetchBySqlEntity($sql, $id);
	}

	///////////////// Inserts /////////////////////////////////////
	static public function insertCols(array $cols, string $values): void {

	}
}