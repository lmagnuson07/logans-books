<?php
/**
 * This file contains the City entity for settlement data imported from UNECE.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since 		1.0
 * @version		1.0
 * @license 	http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 * @Created 	2023-07-13
 */
namespace App\Entities\Demographics;

use App\Entities\Entity;
use DateTime;

/**
 * City entity class that contains the properties, setters, getters, and Entity related methods.
 *
 * This class is designed to inherit the Entity base class.
 *
 * ***Entity classes do not contain or inherit database code.***
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since		1.0
 * @version		1.0
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 * @Created 	2023-07-13
 * @Updated		2023-07-13
 */
class City extends Entity
{
	private ?int $id;
	private ?string $settlement_name;
	private string $settlement_no_diacritics;
	private string $settlement_local_name;
	private string $settlement_local_no_diacritics;
	private ?string $settlement_code;
	private string $function_code;
	private string $status_code;
	private DateTime $date;
	private string $iata;
	private string $coordinates;
	private string $division_code;
	private bool $major_city;
	private int $region_id;
	private ?int $country_id;

	////////////////////////////////////////////////////////
	/// Getters
	public function getId(): int {
		return $this->id;
	}

	public function getSettlementName(): string {
		return $this->settlement_name;
	}

	public function getSettlementNoDiacritics(): string {
		return $this->settlement_no_diacritics;
	}

	public function getSettlementLocalName(): string {
		return $this->settlement_local_name;
	}

	public function getSettlementLocalNoDiacritics(): string {
		return $this->settlement_local_no_diacritics;
	}

	public function getSettlementCode(): string {
		return $this->settlement_code;
	}

	public function getFunctionCode(): string {
		return $this->function_code;
	}

	public function getStatusCode(): string {
		return $this->status_code;
	}

	public function getDate(): DateTime {
		return $this->date;
	}

	public function getIata(): string {
		return $this->iata;
	}

	public function getCoordinates(): string {
		return $this->coordinates;
	}

	public function getDivisionCode(): string {
		return $this->division_code;
	}

	public function getMajorCity(): bool {
		return $this->major_city;
	}

	public function getRegionId(): int {
		return $this->region_id;
	}

	public function getCountryId(): int {
		return $this->country_id;
	}

	/////////////////////////////////////////////////////
	/// Setters
	public function setId(int $value): void {
		$this->id = $value;
	}

	public function setSettlementName(string $value): void {
		$this->settlement_name = $value;
	}

	public function setSettlementNoDiacritics(string $value): void {
		$this->settlement_no_diacritics = $value;
	}

	public function setSettlementLocalName(string $value): void {
		$this->settlement_local_name = $value;
	}

	public function setSettlementLocalNoDiacritics(string $value): void {
		$this->settlement_local_no_diacritics = $value;
	}

	public function setSettlementCode(string $value): void {
		$this->settlement_code = $value;
	}

	public function setFunctionCode(string $value): void {
		$this->function_code = $value;
	}

	public function setStatusCode(string $value): void {
		$this->status_code = $value;
	}

	public function setDate(DateTime $value): void {
		$this->date = $value;
	}

	public function setIata(string $value): void {
		$this->iata = $value;
	}

	public function setCoordinates(string $value): void {
		$this->coordinates = $value;
	}

	public function setDivisionCode(string $value): void {
		$this->division_code = $value;
	}

	public function setMajorCity(bool $value): void {
		$this->major_city = $value;
	}

	public function setRegionId(int $value): void {
		$this->region_id = $value;
	}

	public function setCountryId(int $value): void {
		$this->country_id = $value;
	}

}