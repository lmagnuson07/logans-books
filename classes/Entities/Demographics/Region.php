<?php
/**
 * This file contains the Region entity for settlement data imported from UNECE.
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

/**
 * Region entity class that contains the properties, setters, getters, and Entity related methods.
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
class Region extends Entity
{
	private ?int $id;
	private string $region_name;
	private ?string $region_code;
	private ?string $region_type;
	private int $country_id;
	private ?int $priority;

	////////////////////////////////////////////////////////
	/// Getters
	public function getId(): int {
		return $this->id;
	}
	public function getRegionName(): string {
		return $this->region_name;
	}
	public function getRegionCode(): string {
		return $this->region_code;
	}
	public function getRegionType(): string {
		return $this->region_type;
	}
	public function getCountryId(): int {
		return $this->country_id;
	}
	public function getPriority(): int {
		return $this->priority;
	}

	/////////////////////////////////////////////////////
	/// Setters
	public function setId(int $value): void {
		$this->id = $value;
	}
	public function setRegionName(string $value): void {
		$this->region_name = $value;
	}
	public function setRegionCode(string $value): void {
		$this->region_code = $value;
	}
	public function setRegionType(string $value): void {
		$this->region_type = $value;
	}
	public function setCountryId(int $value): void {
		$this->country_id = $value;
	}
	public function setPriority(int $value): void {
		$this->priority = $value;
	}
}