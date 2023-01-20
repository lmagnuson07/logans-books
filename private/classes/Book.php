<?php

namespace App\objects;
class Book
{
	private int $id;
	private string $title;
	private string $tagline;
	private string $synopsis;
	private string $number_of_pages;
	private string $format;
	private string $language;
	private string $cover_image_url;
	private string $is_available;
	private int $qty_in_stock;
	private int $qty_on_order;
	private float $current_price;
	public function __construct($args=[]) {
		// dynamically set properties
		foreach($args as $k=>$v) {
			if(property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}
}
