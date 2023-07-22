<?php

namespace App\Repositories\Demographics;

use App\DB;
use App\Entities\Demographics\Country;
use App\Repositories\EntityQueries;

class CountryRepository extends EntityQueries
{
	public function __construct(DB $db) {
		parent::__construct($db, Country::class);
	}

	public function fetchById() {

	}
}