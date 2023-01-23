<?php

namespace App\Entities;

class BookAuthor
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
}