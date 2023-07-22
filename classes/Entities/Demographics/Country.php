<?php
/**
 * This file contains the Country entity for settlement data imported from UNECE.
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
use DateTimeZone;

/**
 * Country entity class that contains the properties, setters, getters, and Entity related methods.
 * Also contains default values for properties in the setter methods.
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
class Country extends Entity
{
	protected ?int $id;
	protected string $country_name;
	protected string $country_code;
	protected ?string $iso_code;
	protected ?bool $has_tir;
	protected ?string $association_code;
	protected ?string $national_association;
	protected ?int $priority;
	protected ?int $version;
	protected DateTime|string|null $created_time;
	protected DateTime|string|null $updated_time;

	public function __construct($args = []) {
		parent::__construct($args);
	}
	////////////////////////////////////////////////////////
	/// Getters
	public function getId(): int {
		return $this->id;
	}

	public function getCountryName(): string {
		return $this->country_name;
	}

	public function getCountryCode(): string {
		return $this->country_code;
	}

	public function getIsoCode(): string {
		return $this->iso_code;
	}

	public function getHasTir(): bool {
		return $this->has_tir;
	}

	public function getAssociationCode(): string {
		return $this->association_code;
	}

	public function getNationalAssociation(): string {
		return $this->national_association;
	}

	public function getPriority(): int {
		return $this->priority;
	}

	public function getVersion(): int {
		return $this->version;
	}

	public function getCreatedTime(): ?DateTime {
		return $this->created_time;
	}

	public function getUpdatedTime(): ?DateTime {
		return $this->updated_time;
	}

	/////////////////////////////////////////////////////
	/// Setters
	public function setId(?int $value = null): void {
		$this->id = $value;
	}

	public function setCountryName(string $value = ""): void {
		$this->country_name = $value;
	}

	public function setCountryCode(string $value = ""): void {
		$this->country_code = $value;
	}

	public function setIsoCode(?string $value = null): void {
		$this->iso_code = $value;
	}

	public function setHasTir(?bool $value = null): void {
		$this->has_tir = $value;
	}

	public function setAssociationCode(?string $value = null): void {
		$this->association_code = $value;
	}

	public function setNationalAssociation(?string $value = null): void {
		$this->national_association = $value;
	}

	public function setPriority(?int $value = null): void {
		$this->priority = $value;
	}

	public function setVersion(?int $value = null): void {
		$this->version = $value;
	}

	public function setCreatedTime(DateTime|string|null $value = null): void {
		if (is_string($value)) {
			$timeZone = new DateTimeZone(DEFAULT_TIMEZONE);
			$value = DateTime::createFromFormat("Y-m-d H:i:s", $value, $timeZone);
			if (!$value) { $value = null; }
		}
		$this->created_time = $value;
	}

	public function setUpdatedTime(DateTime|string|null $value = null): void {
		if (is_string($value)) {
			$timeZone = new DateTimeZone(DEFAULT_TIMEZONE);
			$value = DateTime::createFromFormat("Y-m-d H:i:s", $value, $timeZone);
			if (!$value) { $value = null; }
		}
		$this->updated_time = $value;
	}
}
