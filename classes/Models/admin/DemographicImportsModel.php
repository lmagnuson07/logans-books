<?php

namespace App\Models\admin;

use App\Functions\ParseCsv;
use App\Models\Model;

class DemographicImportsModel extends Model
{
	private array $csvFiles;

	public function __construct(array $csvFiles, ParseCsv $csvParser) {
		parent::__construct();
		$this->csvFiles = $csvFiles;
	}
}