<?php

namespace App\Entities;
use App\Shared\DBObj;

class BookEdition extends DBObj
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