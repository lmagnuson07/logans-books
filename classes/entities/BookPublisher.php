<?php

namespace App\Entities;
use App\Shared\EntityQueries;

class BookPublisher extends EntityQueries
{
	public int $id;
	public string $name;
	public string $street_address;
	public string $postal_code;
	public int $city_id;
	public string $phone;
	public string $email;
	public string $website_url;
	public function __construct($args=[]){
		// dynamically set properties
		foreach($args as $k=>$v) {
			if(property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

}