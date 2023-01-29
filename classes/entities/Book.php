<?php

namespace App\Entities;
use App\Shared\DBObj;

class Book extends DBObj
{
	public int $id;
	public float $current_price;
	public int $qty_in_stock;
	public int $qty_on_order;
	public string $title;
	public string $tagline;
	public string $synopsis;
	public int $number_of_pages;
	public string $format;
	public string $language;
	public string $cover_image_url;
	public bool $is_available;
	public array $genres = [];
	public array $categories = [];
	public array $editions = [];
	public array $authors = [];
	public array $publishers = [];
	public function __construct($args=[]) {
		// dynamically set properties
		foreach($args as $k=>$v) {
			// FIXME: Fix this when ability to add multiple authors/publishers is implemented.
			if ($k == 'authors') {
				$this->authors = $v;
			}
			elseif ($k == 'publishers') {
				$this->publishers = $v;
			}
			elseif(property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}
}
