<?php

namespace App\Entities;
use App\Functions\HelperFunctions;
use App\Shared\EntityQueries;

class Book extends EntityQueries
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
	//////////// Setup /////////////////////////////////////////////////////////
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
	public function setDefaults(): void {
		// Cant do default properties on the class in the constructor because of PDO FETCH_CLASS. So this method is needed.
		$this->id = 0;
		$this->current_price = 0;
		$this->qty_in_stock = 0;
		$this->qty_on_order = 0;
		$this->title = '';
		$this->tagline = '';
		$this->synopsis = '';
		$this->number_of_pages = 0;
		$this->format = '';
		$this->language = '';
		$this->cover_image_url = '';
		$this->is_available = true;
	}
	static public function getBookObj(array $books): array {
		$bookObj = [];
		foreach($books as $i=>$b) {
			if (!isset($bookObj['id'])) {
				$bookObj['id'] = $b->id;
				$bookObj['current_price'] = $b->current_price;
				$bookObj['qty_in_stock'] = $b->qty_in_stock;
				$bookObj['qty_on_order'] = $b->qty_on_order;
				$bookObj['title'] = $b->title;
				$bookObj['tagline'] = $b->tagline;
				$bookObj['synopsis'] = $b->synopsis;
				$bookObj['number_of_pages'] = $b->number_of_pages;
				$bookObj['format'] = $b->format;
				$bookObj['language'] = $b->language;
				$bookObj['cover_image_url'] = $b->cover_image_url;
				$bookObj['is_available'] = $b->is_available;
			}
			HelperFunctions::add_to_array_if_unique($bookObj, key: 'genres', value: $b->genre_id);
			HelperFunctions::add_to_array_if_unique($bookObj, key: 'categories', value: $b->category_id);
			HelperFunctions::add_to_array_if_unique($bookObj, key: 'editions', value: $b->edition_id);
			HelperFunctions::add_to_array_if_unique($bookObj, key: 'authors', value: $b->author_id);
			HelperFunctions::add_to_array_if_unique($bookObj, key: 'publishers', value: $b->publisher_id);
		}
		return $bookObj;
	}
	// TODO: Remove this tempFlag when author and publisher form is implemented
	static public function getUpdateAndDeleteLists(array $oldRecords, array $newRecords, bool $tempFlag=false): array {
		$lists = [];

		$oldRecordsIds = array_map(function($i) {
			foreach($i as $k=>$v) {
				if ($k !== 'id') {
					return $v;
				}
			}
		}, $oldRecords);

		// Converts the string results from the form to integers and only returns integers (validates input values).
		$newRecords = array_map(function ($v) {
			$varInt = (int)$v;
			if($varInt) {
				return $varInt;
			}
		}, $newRecords);

		if (!$tempFlag) {
			foreach($oldRecordsIds as $k=>$v) {
				if (!in_array($v, $newRecords)) { $lists['deleteList'][] = HelperFunctions::h($oldRecords[$k]->id); }
			}
		}

		foreach($newRecords as $g) {
			if (!in_array($g, $oldRecordsIds)) { $lists['updateList'][] = HelperFunctions::h($g); }
		}
		return $lists;
	}
	////////////////// Queries /////////////////////////////////////////
	static public function manyToManyRelationships(int $bookId): array {
		$books = [];
		$sql = "SELECT b.id, b.current_price, b.qty_in_stock, b.qty_on_order, 
		b.title, b.tagline, b.synopsis, b.number_of_pages, b.format, 
		b.language, b.cover_image_url, b.is_available,
		bgd.genre_id, bg.name AS genre_name, 
			bcd.category_id, bc.name AS category_name, 
			bed.edition_id, be.name AS edition_name,
			bad.author_id, CONCAT(ba.first_name, \" \", ba.last_name) AS author_fullname,
			bpd.publisher_id, bp.name AS publisher_name
		FROM book b
		INNER JOIN bookgenredetail bgd
			ON bgd.book_id = b.id
		INNER JOIN bookgenre bg
			ON bg.id = bgd.genre_id
		INNER JOIN bookcategorydetail bcd
			ON bcd.book_id = b.id
		INNER JOIN bookcategory bc
			ON bc.id = bcd.category_id
		INNER JOIN bookeditiondetail bed
			ON bed.book_id = b.id
		INNER JOIN bookedition be
			ON be.id = bed.edition_id
		INNER JOIN bookauthordetail bad
			ON bad.book_id = b.id
		INNER JOIN bookauthor ba
			ON ba.id = bad.author_id
		INNER JOIN bookpublisherdetail bpd
			ON bpd.book_id = b.id
		INNER JOIN bookpublisher bp
			ON bp.id = bpd.publisher_id
		WHERE b.id = ?";

		$books = static::fetchAllBySql(sql: $sql, id: $bookId);

		if (empty($books)) {
			// For books that are recently added and have no many - many relationships
			$sql = "SELECT b.id, b.current_price, b.qty_in_stock, b.qty_on_order, 
				b.title, b.tagline, b.synopsis, b.number_of_pages, b.format, 
				b.language, b.cover_image_url, b.is_available
			FROM book b
			WHERE b.id = :id";

			$books = static::fetchAllBySql(sql: $sql, id: $bookId);
		}

		return $books;
	}
	static public function getLists(): array {
		$lists = [];
		$lists['genres'] = BookGenre::fetchCols(cols: ['id', 'name'], orderBy: ['name']);
		$lists['categories'] = BookCategory::fetchCols(cols: ['id', 'name'], orderBy: ['name']);
		$lists['editions'] = BookEdition::fetchCols(cols: ['id', 'name'], orderBy: ['name']);
		$lists['authors'] = BookAuthor::fetchCols(cols: ['id', 'first_name', 'last_name'], orderBy: ['first_name']);
		$lists['publishers'] = BookPublisher::fetchCols(cols: ['id', 'name'], orderBy: ['name']);

		return $lists;
	}
	//////////// Inserts /////////////////////////////////////////////////
	public function insertPostData(array $ignoreList=[], array $convert=[]): int {
		$cols = parent::getClassCols($ignoreList);

		$sql = 'INSERT INTO book (' . join(',', array_values($cols))
				. ') VALUES (' . join(',', array_values(array_map(fn ($i) => ":$i", $cols))) .')';

		parent::performInstanceDML($sql, ignoreList: $ignoreList, convert: $convert);
		$insertId = (int)static::$db->lastInsertId();
		$this->id = $insertId;

		return $insertId;
	}
	public function getPostPlaceholderAndInsertData(array $items, bool $isInsert=true): array {
		$rowCount = count($items);

		if($isInsert) {
			$insertData = [];
			foreach($items as $r){
				$insertData[] = $this->id;
				$insertData[] = (int)HelperFunctions::h($r);
			}
			$placeHolders = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";

			$arr['insertData'] = $insertData;
			$arr['placeHolders'] = $placeHolders;
		} else {
			$arr['placeHolders'] = implode(",",array_map(fn () => "?", $items));
		}

		return $arr;
	}
	//////////////// Updates ///////////////////////////////////////////////////
	public function updateWithPostData(array $ignoreList=[], array $convert=[]): void {
		// TODO: Check if the book exists before performing update.
		$cols = parent::getClassCols($ignoreList);

		$sql = 'UPDATE book SET ' . join(',', array_values(array_map(fn ($i) => "$i=:$i", $cols))) .
            	' WHERE id=' . $this->id . ' LIMIT 1';

		parent::performInstanceDML($sql, ignoreList: $ignoreList, convert: $convert);
	}
}
