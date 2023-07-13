<?php

namespace App\Controllers\Admin;

use App\App;
use App\Superglobals\Post;
use App\Superglobals\Session;
use PDOException;
use App\Exceptions\DataInsertException;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileNotReadableException;
use App\Exceptions\ParameterExceptions\EmptyParameterException;
use App\Exceptions\ParameterExceptions\InvalidArgumentException;
use App\Functions\ParseCsv;
use App\Models\admin\DemographicImportsModel;
use App\Routines\BasicQueries;
use App\View;

class ImportsController
{
	private array $page_dict;
	private array $uneceFiles = [
		'subdivision_codes' => '2022-2_SubdivisionCodes.csv',
		'code_list1' => '2022-2_UNLOCODE_CodeListPart1.csv',
		'code_list2' => '2022-2_UNLOCODE_CodeListPart2.csv',
		'code_list3' => '2022-2_UNLOCODE_CodeListPart3.csv',
		'iso_countries' => 'ISO_Countries.csv'
	];

	public function index(): View {
		if (isset($_SESSION['successfulImportNumber']) && $_SESSION['successfulImportNumber'] == 0) {
			Session::unsetSession("successfulImportNumber");
			Session::unsetSession("totalImportCount");
		}
		$this->page_dict['successfulImportNumber'] = $_SESSION['successfulImportNumber'] ?? null;
		$this->page_dict['totalImportCount'] = $_SESSION['totalImportCount'] ?? null;

		return View::make(view: 'admin/imports/index', pageDictInit: $this->page_dict);
	}

	/**
	 * Post only.
	 *
	 * @return View
	 */
	public function importDemographics(): View {
		Post::initPostArray(Post::getRawPostArray());
		$postArray = Post::getPostArray();

		if (!isset($postArray['importDemographicsBtn']) || $postArray['importDemographicsBtn'] !== "Import Demographic Data") {
			return View::make(view: 'errors/404');
		}

		$db = App::db();
		BasicQueries::init($db);

		try {
			$csvParser = new ParseCsv();
			$demographicImportsModel = new DemographicImportsModel(csvFiles: $this->uneceFiles, csvParser: $csvParser);

			if (!isset($_SESSION['successfulImportNumber'])) {
				Session::setSession("successfulImportNumber", 0);
			}
			$countryCount = BasicQueries::countTableRecords("country");

			if (!isset($_SESSION['stagedImportData'])) {
				$db->recreateDb();
				$stagedImportData = $demographicImportsModel->stageImportData();

				// Insert country data first since it will have child records in settlement and region arrays.
				BasicQueries::insertKeyValues($stagedImportData['countryArray'], 'country');

				// Convert temp country_codes to the countries id field in settlement and region arrays.
				$stagedImportData['countryArray'] = BasicQueries::selectAllFromTable('country');
				$stagedImportData = $demographicImportsModel->setRegionRelationships($stagedImportData);

				// Insert region data so we have ids for settlement foreign keys.
				BasicQueries::insertKeyValues($stagedImportData['regionArray'], 'region');

				$stagedImportData['regionArray'] = BasicQueries::selectAllFromTable('region');

				Session::setSession("stagedImportData", $stagedImportData);
				Session::setSession("tempSettlementArray", []);
			} else {
				$stagedImportData = $_SESSION['stagedImportData'];
			}

			// Loop through a certain amount of data and keep track of the data and how many loops in the session.
			// Script is too demanding with this much data to run the entire data set.
			Session::setSession("stagedImportData", $stagedImportData);
			Session::setSession("currentlyImporting", true);

			$chunkedArray = array_chunk($stagedImportData['settlementArray'], 27000);
			$tempArr = $demographicImportsModel->setSettlementRelationships($stagedImportData, $chunkedArray[$_SESSION['successfulImportNumber']]);

			// 65000 placeholders per chunk (13 settlement properties)
			$chunkedInsertArray = array_chunk($tempArr, 4500);
			foreach ($chunkedInsertArray as $arr) {
				BasicQueries::insertKeyValues($arr, 'city');
			}

			$_SESSION['totalImportCount'] = $_SESSION['totalImportCount'] ?? count($chunkedArray);
			if ($_SESSION['totalImportCount'] !== $_SESSION['successfulImportNumber']) {
				Session::setSession("successfulImportNumber", $_SESSION['successfulImportNumber'] + 1);
			}
			// We are done importing
			if ($_SESSION['totalImportCount'] === $_SESSION['successfulImportNumber']) {
				Session::setSession("currentlyImporting", false);

				Session::setSession("successfulImportNumber", 0);
				Session::setSession("totalImportCount", 0);

				Session::unsetSession("stagedImportData");
			}

			// Set up page variables.
			$this->page_dict['successfulImportNumber'] = $_SESSION['successfulImportNumber'];
			$this->page_dict['totalImportCount'] = $_SESSION['totalImportCount'];

		} catch (
			FileNotReadableException|FileNotFoundException
			|DataInsertException|EmptyParameterException
			|InvalidArgumentException|PDOException $ex
		) {
			$this->page_dict['errorMsg'] = $ex->getMessage();
			Session::unsetSession("stagedImportData");
			Session::unsetSession("totalImportCount");
			Session::unsetSession("successfulImportNumber");
		}

		return View::make(view: 'admin/imports/index', pageDictInit: $this->page_dict);
	}
}