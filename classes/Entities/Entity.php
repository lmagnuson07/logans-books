<?php
/**
 * This file contains the base Entity class that is designed to be inherited by all Entity classes.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since 		1.0
 * @version		1.0
 * @license 	http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 * @Created 	2023-07-13
 */
namespace App\Entities;

/**
 * Contains shared methods and a class constructor that calls the entities setters based on an associative array passed to the method for the Entity that will inherit this class.
 *
 * This class is designed to be inherited by all Entity classes.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since		1.0
 * @version		1.0
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 * @Created 	2023-07-13
 * @Updated		2023-07-13
 */
class Entity
{
	public function __construct($args=[]) {
		if (empty($args)) {
			$args = get_class_vars(static::class);
		}
		foreach($args as $k=>$v) {
			$funcName = $this->propertyToSetterMethodName($k);
			if (method_exists($this, $funcName)) {
				if ($v === null) {
					// Uses the default value on the setter.
					call_user_func([$this, $funcName]);
				} else {
					call_user_func([$this, $funcName], $v);
				}
			}
		}
	}

	/**
	 * Transforms a classes property name (passed to the method as a string) into its setter method name.
	 * Assumes the property is named with underscore (_) syntax for entity properties mapped to database fields.
	 *
	 * @param $string
	 * @return string
	 */
	public function propertyToSetterMethodName($string): string {
		$subStrings = explode("_", $string);
		$subStrings = array_map("ucfirst", $subStrings);

		return "set" . implode($subStrings);
	}

	/**
	 * Loops through all properties ($this) of the instantiated Entity class and returns them in an array to be used in entity queries.
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
}