<?php

namespace App\Controllers\Admin;

use App\App;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileNotReadableException;
use App\Functions\ParseCsv;
use App\Models\admin\DemographicImportsModel;
use App\View;

class ImportsController
{
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
			$demographicImportsModel->stageImportData();
 		} catch (FileNotReadableException|FileNotFoundException $ex) {
			echo $ex->getMessage();
		}

		return View::make(view: 'admin/imports/index', params: ['foo' => 'bar']);
	}
}