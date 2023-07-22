<?php

namespace App\Functions;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileNotReadableException;
use App\Superglobals\Session;

class ParseCsv
{
	private string $fileName;
	private mixed $header;
	private array $data = array();
	private int $row_count = 0;

	/**
	 *
	 */
	public function __construct() {

	}

	/**
	 * @throws FileNotReadableException|FileNotFoundException
	 */
	public function file($fileName): bool {
		if(!file_exists($fileName)) {
			throw new FileNotFoundException(message: "File does not exist.");
		} elseif(!is_readable($fileName)) {
			throw new FileNotReadableException();
		}
		$this->fileName = $fileName;
		return true;
	}

	/**
	 * @throws FileNotReadableException|FileNotFoundException
	 */
	private function setFile($fileName): void {
		if($fileName != '') {
			if ($this->file($fileName)) {
				Session::setSession('fileFeedbackMsg', "[$fileName] loaded");
			}
		}
	}

	/**
	 * @throws FileNotReadableException|FileNotFoundException
	 */
	public function parse(string $fileName, string $delimiter = ','): array {
		$this->setFile($fileName);

		if(!isset($this->fileName)) {
			throw new FileNotFoundException(message: "CSV file not set.");
		}

		// clear any previous results
		$this->reset();

		$file = fopen($this->fileName, 'r');
		while(!feof($file)) {
			$row = fgetcsv($file, 0, $delimiter);
			if($row == null || $row === false || $row == '') { continue; }
			if(!$this->header) {
				$this->header = $row;
			} else {
				$this->data[] = array_combine($this->header, $row);
				$this->row_count++;
			}
		}
		fclose($file);
		return $this->data;
	}

	private function reset(): void {
		$this->header = null;
		$this->data = [];
		$this->row_count = 0;
	}

	public function removeZeroWidthSpaceCharacters(array $arr): array {
		$trimmedRegionArray = [];
		foreach($arr as $key => $value) {
			$newKey = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $key);
			$newValue = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $value);
			$trimmedRegionArray[$newKey] = $newValue;
		}
		return $trimmedRegionArray;
	}
}