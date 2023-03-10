<?php

namespace App\Entities;
use App\Shared\EntityQueries;

class BookEdition extends EntityQueries
{
	public int $id;
	public string $name;
	public string $description;
	public function __construct($args=[]){
		// dynamically set properties
		foreach($args as $k=>$v) {
			if(property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}
}