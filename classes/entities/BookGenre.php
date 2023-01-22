<?php

namespace App\Entities;

class BookGenre
{
	public int $id;
	public string $description;
	public string $name;
	public bool $is_fiction;
	public function __construct($args=[]){
		// dynamically set properties
		foreach($args as $k=>$v) {
			if(property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}
}