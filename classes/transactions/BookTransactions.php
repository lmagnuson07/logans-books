<?php

namespace App\Transactions;

use App\Entities\Book;
use App\Shared\BasicQueries;
use App\Shared\DBObj;

class BookTransactions extends DBObj
{
	protected array $failure = [];
	protected array $input; // post data
	protected Book $bookGateway;
	public function __construct(Book $bookGateway) {
		$this->bookGateway = $bookGateway;
	}
	public function getInput(): array {
		return $this->input;
	}
	public function getFailure(): array {
		return $this->failure;
	}
	public function filterInput($input): array {
		// Filter the input (htmlchars, strip_tags, etc)
		return $input;
	}
	public function submitNewBook($input): void { // probably don't need bookId
		$this->input = $this->filterInput($input);
		($this->bookGateway)($input);
		$this->failure = [];
		// insert book
		try {
			static::$db->beginTransaction();
			$newBookId = $this->bookGateway->insertPostData(ignoreList: ['id','genres','categories','editions','authors','publishers']);

			// Insert into Book Genre Details
			if (isset($this->bookGateway->genres) && !empty($this->bookGateway->genres)) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($this->bookGateway->genres);
				BasicQueries::insertCols(cols: ['book_id', 'genre_id'], placeHolders: $data["placeHolders"], tableName: "bookgenredetail", insertData: $data["insertData"]);
			}

			// Insert into Book Category Details
			if (isset($this->bookGateway->categories) && !empty($this->bookGateway->categories)) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($this->bookGateway->categories);
				BasicQueries::insertCols(cols: ['book_id', 'category_id'], placeHolders: $data["placeHolders"], tableName: "bookcategorydetail", insertData: $data["insertData"]);
			}

			// Insert into Book Edition Details
			if (isset($this->bookGateway->editions) && !empty($this->bookGateway->editions)) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($this->bookGateway->editions);
				BasicQueries::insertCols(cols: ['book_id', 'edition_id'], placeHolders: $data["placeHolders"], tableName: "bookeditiondetail", insertData: $data["insertData"]);
			}

			// Insert into Book Author Details
			if (isset($this->bookGateway->authors) && !empty($this->bookGateway->authors) && !in_array("none", $this->bookGateway->authors)) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($this->bookGateway->authors);
				BasicQueries::insertCols(cols: ['book_id', 'author_id'], placeHolders: $data["placeHolders"], tableName: "bookauthordetail", insertData: $data["insertData"]);
			}

			// Insert into Book Publisher Details
			if (isset($this->bookGateway->publishers) && !empty($this->bookGateway->publishers)  && !in_array("none", $this->bookGateway->publishers)) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($this->bookGateway->publishers);
				BasicQueries::insertCols(cols: ['book_id', 'publisher_id'], placeHolders: $data["placeHolders"], tableName: "bookpublisherdetail", insertData: $data["insertData"]);
			}

			static::$db->commit();
		} catch (\Throwable $e) {
			if (static::$db->inTransaction()) {
				static::$db->rollBack();
			}
		}
		$result = true;
		if ($result) {

		} else {
			$this->failure[] = "Failure";
		}
	}
	public function updateExistingBook(array $input): void {
		$this->input = $this->filterInput($input);
		($this->bookGateway)($input);
		$this->failure = [];
		// update book
		try {
			static::$db->beginTransaction();
			$this->bookGateway->updateWithPostData(ignoreList: ['id', 'genres', 'categories', 'editions', 'authors', 'publishers'], convert: ['convert_bool' => true, 'convert_item' => 'is_available']);

			// Update Book Genre Details
			$oldRecords = BasicQueries::fetchBridgingTableColsById(cols: ['id', 'genre_id'], id: $this->bookGateway->id, tableName: "bookgenredetail", targetId: "book_id");
			$lists = Book::getUpdateAndDeleteLists(oldRecords: $oldRecords, newRecords: $this->bookGateway->genres);

			// insert
			if (!empty($lists['updateList'])) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($lists['updateList']);
				BasicQueries::insertCols(cols: ['book_id', 'genre_id'], placeHolders: $data["placeHolders"], tableName: "bookgenredetail", insertData: $data["insertData"]);
			}

			// delete
			if (!empty($lists['deleteList'])) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData(items: $lists['deleteList'], isInsert: false);
				BasicQueries::deleteRecords(placeHolders: $data["placeHolders"], tableName: "bookgenredetail", ids: $lists['deleteList']);
			}

			// Update Book Category Details
			$oldRecords = BasicQueries::fetchBridgingTableColsById(cols: ['id', 'category_id'], id: $this->bookGateway->id, tableName: "bookcategorydetail", targetId: "book_id");
			$lists = Book::getUpdateAndDeleteLists(oldRecords: $oldRecords, newRecords: $this->bookGateway->categories);

			// insert
			if (!empty($lists['updateList'])) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($lists['updateList']);
				BasicQueries::insertCols(cols: ['book_id', 'category_id'], placeHolders: $data["placeHolders"], tableName: "bookcategorydetail", insertData: $data["insertData"]);
			}

			// delete
			if (!empty($lists['deleteList'])) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData(items: $lists['deleteList'], isInsert: false);
				BasicQueries::deleteRecords(placeHolders: $data["placeHolders"], tableName: "bookcategorydetail", ids: $lists['deleteList']);
			}

			// Update Book Edition Details
			$oldRecords = BasicQueries::fetchBridgingTableColsById(cols: ['id', 'edition_id'], id: $this->bookGateway->id, tableName: "bookeditiondetail", targetId: "book_id");
			$lists = $this->bookGateway::getUpdateAndDeleteLists(oldRecords: $oldRecords, newRecords: $this->bookGateway->editions);

			// insert
			if (!empty($lists['updateList'])) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($lists['updateList']);
				BasicQueries::insertCols(cols: ['book_id', 'edition_id'], placeHolders: $data["placeHolders"], tableName: "bookeditiondetail", insertData: $data["insertData"]);
			}

			// delete
			if (!empty($lists['deleteList'])) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData(items: $lists['deleteList'], isInsert: false);
				BasicQueries::deleteRecords(placeHolders: $data["placeHolders"], tableName: "bookeditiondetail", ids: $lists['deleteList']);
			}

			// Update Book Author Details
			$oldRecords = BasicQueries::fetchBridgingTableColsById(cols: ['id', 'author_id'], id: $this->bookGateway->id, tableName: "bookauthordetail", targetId: "book_id");
			$lists = Book::getUpdateAndDeleteLists(oldRecords: $oldRecords, newRecords: $this->bookGateway->authors, tempFlag: true);

			// insert
			if (!empty($lists['updateList'])) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($lists['updateList']);
				BasicQueries::insertCols(cols: ['book_id', 'author_id'], placeHolders: $data["placeHolders"], tableName: "bookauthordetail", insertData: $data["insertData"]);
			}

			// delete (cant delete right now since existing authors are disabled on the form)
//		if (!empty($lists['deleteList'])) {
//			$data = $this->bookGateway->getPostPlaceholderAndInsertData(items: $lists['deleteList'], isInsert: false);
//			BasicQueries::deleteRecords(placeHolders: $data["placeHolders"], tableName: "bookauthordetail", ids: $lists['deleteList']);
//		}

			// Update Book Publisher Details
			$oldRecords = BasicQueries::fetchBridgingTableColsById(cols: ['book_id', 'publisher_id'], id: $this->bookGateway->id, tableName: "bookpublisherdetail", targetId: "book_id");
			$lists = Book::getUpdateAndDeleteLists(oldRecords: $oldRecords, newRecords: $this->bookGateway->publishers, tempFlag: true);

			// insert
			if (!empty($lists['updateList'])) {
				$data = $this->bookGateway->getPostPlaceholderAndInsertData($lists['updateList']);
				BasicQueries::insertCols(cols: ['book_id', 'publisher_id'], placeHolders: $data["placeHolders"], tableName: "bookpublisherdetail", insertData: $data["insertData"]);
			}

			// delete (cant delete right now since existing publishers are disabled on the form)
//		if (!empty($lists['deleteList'])) {
//			$data = $this->bookGateway->getPostPlaceholderAndInsertData(items: $lists['deleteList'], isInsert: false);
//			\App\Shared\BasicQueries::deleteRecords(placeHolders: $data["placeHolders"], tableName: "bookpublisherdetail", ids: $lists['deleteList']);
//		}
			static::$db->commit();
		} catch (\Throwable $e) {
			if (static::$db->inTransaction()) {
				static::$db->rollBack();
			}
		}

		$result = true;
		if ($result) {

		} else {
			$this->failure[] = "Failure";
		}
	}
}