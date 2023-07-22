<?php

namespace App\Models\admin;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileNotReadableException;
use App\Functions\ParseCsv;
use App\Models\Model;
use DateTime;

class DemographicImportsModel extends Model
{
	private string $unecePath = UNECE_PATH;
	private array $csvFiles;
	private ParseCsv $csvParser;

	public function __construct(array $csvFiles, ParseCsv $csvParser) {
		parent::__construct();
		$this->csvFiles = $csvFiles;
		$this->csvParser = $csvParser;
	}

	/**
	 * Reads data from the UNECE csv files and stages the data into 3 arrays ($countryArray, $regionArray, and $settlementArray) for database insertion.
	 *
	 * $regionArray and $settlementArray store temporary region_codes/country_codes to use for setting up the foreign key relationships.
	 *
	 * @return array
	 * @throws FileNotFoundException
	 * @throws FileNotReadableException
	 */
	public function stageImportData(): array {
		$countryArray = [];
		$regionArray = [];
		$settlementArray = [];

		$subdivisionCodes = $this->csvParser->parse(fileName: $this->unecePath . $this->csvFiles['subdivision_codes']);
		$codeListPart1 = $this->csvParser->parse(fileName: $this->unecePath . $this->csvFiles['code_list1']);
		$codeListPart2 = $this->csvParser->parse(fileName: $this->unecePath . $this->csvFiles['code_list2']);
		$codeListPart3 = $this->csvParser->parse(fileName: $this->unecePath . $this->csvFiles['code_list3']);
		$isoCountries = $this->csvParser->parse(fileName: $this->unecePath . $this->csvFiles['iso_countries']);

		////////////////////////////////////////////////////
		/// Setup the countries array (missing country_code)
		foreach($isoCountries as $isoCountry) {
			$tempArr = [];
			$tempArr['country_name'] = $isoCountry['country_name'];
			$tempArr['has_tir'] = isset($isoCountry['has_tir']);
			$tempArr['association_code'] = $isoCountry['association_code'];
			$tempArr['iso_code'] = $isoCountry['iso_code'];
			$tempArr['national_association'] = $isoCountry['national_association'];
			$countryArray[] = $tempArr;
		}

		///////////////////////////////////////////////////
		/// Setup the region array.
		foreach($subdivisionCodes as $region) {
			$trimmedRegionArr = $this->csvParser->removeZeroWidthSpaceCharacters($region);
			if (!is_numeric($trimmedRegionArr['region_code']) && !empty($trimmedRegionArr['region_code'])) {
				$tempArr = [];
				$tempArr['region_name'] = $trimmedRegionArr['region_name'];
				$tempArr['region_code'] = $trimmedRegionArr['region_code'];
				$tempArr['region_type'] = $trimmedRegionArr['region_type'];
				$tempArr['temp_country_code'] = $trimmedRegionArr['country_code'];
				$regionArray[] = $tempArr;
			}
		}

		//////////////////////////////////////////////////
		/// Setup the settlement array and missing data
		/// from country array (country_code).
		$countryNames = array_map(
			'strtolower',
			array_column($countryArray, 'country_name')
		);

		$this->processCodeList($codeListPart1, $countryNames, $settlementArray, $countryArray);
		$this->processCodeList($codeListPart2, $countryNames, $settlementArray, $countryArray);
		$this->processCodeList($codeListPart3, $countryNames, $settlementArray, $countryArray);

		return [
			"countryArray" => $countryArray,
			"regionArray" => $regionArray,
			"settlementArray" => $settlementArray
		];
	}

	private function processCodeList($codeList, $countryNames, &$settlementArray, &$countryArray): void {
		foreach($codeList as $settlement) {
			$tempArr = [];
			$trimmedSettlementArr = $this->csvParser->removeZeroWidthSpaceCharacters($settlement);

			$emptyFields = 0;
			foreach($trimmedSettlementArr as $s) {
				if (empty($s)) {
					$emptyFields++;
				}
			}
			////////////////////////////////////////
			/// Represents a country/major city row.
			if ($emptyFields >= 8) {
				///////////////////////////////////////
				/// Add the country_code and missing countries.
				$countryName = $trimmedSettlementArr['settlement'];
				if (str_starts_with($trimmedSettlementArr['settlement'], '.')) {
					$countryName = substr($trimmedSettlementArr['settlement'], 1);
				}
				if (str_contains($countryName, '=')) {
					// Represents a major city. Add to settlement table.
					$newCityArr = [];
					$settlementNames = explode('=', $countryName);
					$newCityArr['settlement_name'] = trim($settlementNames[0]);
					$newCityArr['settlement_local_name'] = trim($settlementNames[1]);
					if (!empty($trimmedSettlementArr['settlement_no_diacritics'])) {
						$settlementNamesNoDiacritics = explode('=', $trimmedSettlementArr['settlement_no_diacritics']);
						$newCityArr['settlement_no_diacritics'] = trim($settlementNamesNoDiacritics[0]);
						$newCityArr['settlement_local_no_diacritics'] = trim($settlementNamesNoDiacritics[1]);
					} else {
						$newCityArr['settlement_no_diacritics'] = null;
						$newCityArr['settlement_local_no_diacritics'] = null;
					}
					$newCityArr['major_city'] = true;
					$newCityArr['temp_country_code'] = $trimmedSettlementArr['country_code'];

					$newCityArr['date'] = null;
					$newCityArr['settlement_code'] = null;
					$newCityArr['function_code'] = null;
					$newCityArr['status_code'] = null;
					$newCityArr['iata'] = null;
					$newCityArr['coordinates'] = null;
					$newCityArr['division_code'] = null;
					$settlementArray[] = $newCityArr;
				} elseif (!in_array(strtolower($countryName), $countryNames)) {
					// New country not already in the countries array.
					$newCountryArr = [];
					$newCountryArr['country_name'] = $countryName;
					$newCountryArr['iso_code'] = null;
					$newCountryArr['has_tir'] = null;
					$newCountryArr['association_code'] = null;
					$newCountryArr['national_association'] = null;
					$newCountryArr['country_code'] = $trimmedSettlementArr['country_code'];

					$countryArray[] = $newCountryArr;
				} else {
					// Country that exists in the countries array. Add missing country_code.
					foreach ($countryArray as &$innerArray) {
						if (strtolower($innerArray['country_name']) === strtolower($countryName)) {
							$innerArray['country_code'] = $trimmedSettlementArr['country_code'];
						}
					}
				}
			/////////////////////////////////////
			/// Normal settlement data.
			} else {
				$tempArr['settlement_name'] = $trimmedSettlementArr['settlement'];
				$tempArr['settlement_no_diacritics'] = $trimmedSettlementArr['settlement_no_diacritics'];
				$tempArr['settlement_code'] = $trimmedSettlementArr['settlement_code'];
				$tempArr['function_code'] = $trimmedSettlementArr['function_code'];
				$tempArr['status_code'] = $trimmedSettlementArr['status_code'];
				$tempArr['iata'] = $trimmedSettlementArr['iata'];
				$tempArr['coordinates'] = $trimmedSettlementArr['coordinates'];
				$tempArr['division_code'] = $trimmedSettlementArr['division_code'];
				$tempArr['temp_country_code'] = $trimmedSettlementArr['country_code'];
				$tempArr['settlement_local_name'] = null;
				$tempArr['settlement_local_no_diacritics'] = null;
				$tempArr['major_city'] = false;

				$year = substr($trimmedSettlementArr['date'], 0, 2);
				$month = substr($trimmedSettlementArr['date'], 2, 2);
				if ((int)$year >= 30) {
					$year = '19' . $year;
				} else if ($year >= 20) {
					$year = '20' . $year;
				}
				$dateTime = new DateTime();
				$date = $dateTime
					->setDate((int)$year, (int)$month, 1)
					->format('Y-m-d');
				$tempArr['date'] = $date;
				$settlementArray[] = $tempArr;
			}
		}
	}

	public function setRegionRelationships(array $stagedImportData): array {
		// Set up region foreign keys.
		$newRegionArray = [];
		foreach($stagedImportData['regionArray'] as $region) {
			$regionsCountry = array_filter($stagedImportData['countryArray'], function($val) use ($region) {
				return $region['temp_country_code'] == $val['country_code'];
			});

			if (!empty($regionsCountry)) {
				// Get the inner array.
				$regionsCountry = reset($regionsCountry);
				unset($region['temp_country_code']);
				$region['country_id'] = $regionsCountry['id'];
				$newRegionArray[] = $region;
			}
		}

		$stagedImportData['regionArray'] = $newRegionArray;
		return $stagedImportData;
	}

	public function setSettlementRelationships(array $stagedImportData, array $chunkedArray): array {
		// Set up settlement foreign keys.
		// Always has a parent country.
		// Optionally has a parent region.
		$newSettlementArray = [];
		foreach($chunkedArray as $settlement) {
			$settlementsCountry = array_filter($stagedImportData['countryArray'], function($val) use ($settlement) {
				return $settlement['temp_country_code'] == $val['country_code'];
			});

			if (!empty($settlementsCountry)) {
				// Get the inner array.
				$settlementsCountry = reset($settlementsCountry);
				unset($settlement['temp_country_code']);
				$settlement['country_id'] = $settlementsCountry['id'];

				if (!empty($settlement['division_code']) && !is_numeric($settlement['division_code'])) {
					$settlementsRegion = array_filter($stagedImportData['regionArray'], function($val) use ($settlement) {
						return $settlement['division_code'] == $val['region_code'] && $settlement['country_id'] == $val['country_id'];
					});
				} else {
					$settlementsRegion = [];
				}

				if (!empty($settlementsRegion)) {
					// Get the inner array.
					$settlementsRegion = reset($settlementsRegion);
					$settlement['region_id'] = $settlementsRegion['id'];
				} else {
					$settlement['region_id'] = null;
				}
				$newSettlementArray[] = $settlement;
			}
		}

		return $newSettlementArray;
	}
}