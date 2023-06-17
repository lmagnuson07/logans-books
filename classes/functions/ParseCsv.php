<?php

namespace App\Functions;
use Exception;

class ParseCsv
{
	private string $fileName;
	private mixed $header;
	private array $data = array();
	private int $row_count = 0;

	/**
	 * @throws Exception
	 */
	public function __construct() {

	}

	/**
	 * @throws Exception
	 */
	public function file($fileName): bool {
		if(!file_exists($fileName)) {
			throw new Exception(message: "File does not exist.");
		} elseif(!is_readable($fileName)) {
			throw new Exception(message: "File is not readable.");
		}
		$this->fileName = $fileName;
		return true;
	}

	/**
	 * @throws Exception
	 */
	private function setFile($fileName): void {
		if($fileName != '') {
			if ($this->file($fileName)) {
				Session::setSession('fileFeedbackMsg', "[$fileName] loaded");
			}
		}
	}

	/**
	 * @throws Exception
	 */
	public function parse(string $fileName, string $delimiter = ','): array {
		$this->setFile($fileName);

		if(!isset($this->fileName)) {
			throw new Exception(message: "File not set.");
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
}