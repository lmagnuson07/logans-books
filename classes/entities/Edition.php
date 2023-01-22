<?php

namespace App\Entities;

class Edition
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