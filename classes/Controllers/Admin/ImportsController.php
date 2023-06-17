<?php

namespace App\Controllers\Admin;

use App\App;
use App\Functions\ParseCsv;
use App\Models\admin\DemographicImportsModel;
use App\View;

class ImportsController
{
	private string $csvPath = DATA_FILES_PATH;
	private array $uneceFiles = [
		'subdivision_codes' => '2022-2_SubdivisionCodes.csv',
		'code_list1' => '2022-2_UNLOCODE_CodeListPart1.csv',
		'code_list2' => '2022-2_UNLOCODE_CodeListPart2.csv',
		'code_list3' => '2022-2_UNLOCODE_CodeListPart3.csv',
		'iso_countries' => 'ISO_Countries.csv'
	];

	public function index(): View {
		$db = App::db();
		$csvParser = new ParseCsv();
		$demographicImportsModel = new DemographicImportsModel(csvFiles: $this->uneceFiles, csvParser: $csvParser);


		try {
			$subdivisionCodes = $csvParser->parse(fileName: $this->csvPath . $this->uneceFiles['subdivision_codes']);
			$codeListPart1 = $csvParser->parse(fileName: $this->csvPath . $this->uneceFiles['code_list1']);
			$codeListPart2 = $csvParser->parse(fileName: $this->csvPath . $this->uneceFiles['code_list2']);
			$codeListPart3 = $csvParser->parse(fileName: $this->csvPath . $this->uneceFiles['code_list3']);
			$isoCountries = $csvParser->parse(fileName: $this->csvPath . $this->uneceFiles['iso_countries']);

 		} catch (\Exception) {
			echo "Cant find csv file";
		}

		return View::make(view: 'admin/imports/index', params: ['foo' => 'bar']);
	}
}