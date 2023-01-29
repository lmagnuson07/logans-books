<?php

namespace App\Entities;
use App\Shared\EntityQueries;

class BookAuthor extends EntityQueries
{
	public int $id;
	public string $first_name;
	public string $last_name;
	public string $email;
	public string $image_url;
	public function __construct($args=[]){
		// dynamically set properties
		foreach($args as $k=>$v) {
			if(property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}
	static public function fetchLastAuthor($id): object {
		$sql = "SELECT id, first_name, last_name
		FROM bookauthor WHERE id = ?";
		return static::fetchBySqlEntity($sql, $id);
	}
}