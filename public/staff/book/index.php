<?php
/**
 * @var $db
 */
// setup
if(!isset($page_title)) { $page_title = 'Logan\'s Books'; }
if(!isset($page_heading)) { $page_heading = 'Logan\'s Books'; }

$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
require_once('../../../private/initialize.php');

$page_title = "Book CRUD";
$bookId = $_GET['id'] ?? null;
$action = $_SERVER['PHP_SELF'];

// SQL
// Submit new book
if (App\Functions\HelperFunctions::is_post_request()) {
	if(isset($bookId)) $bookId = null;
		$book = new \App\Entities\Book($_POST['book']);
		$bookGateway = new \App\Entities\Book();
		$bookGateway->setDefaults();

		// Fix to read from session data.
		$bookTransactions = new \App\Transactions\BookTransactions($bookGateway);
		if($book->id === 0) {
			$bookTransactions->submitNewBook($_POST['book']);
		}
		// Update a book:
		elseif ($book->id > 0) {
			$bookTransactions->updateExistingBook($_POST['book']);
		}
}
// Create new Book
if ((int)$bookId === 0 && !is_null($bookId)) {
	$lists = \App\Entities\Book::getLists();
	$genres = $lists['genres'];
	$categories = $lists['categories'];
	$editions = $lists['editions'];
	$authors = $lists['authors'];
	$publishers = $lists['publishers'];

	$book = new App\Entities\Book();
	$book->setDefaults();

// Edit books SQL
} elseif (isset($bookId)) {
	$books = \App\Entities\Book::manyToManyRelationships($bookId);

	// Catches errors if an id that doesn't exist is typed into url.
	if (empty($books)) {
		App\Functions\HelperFunctions::redirect_to(App\Functions\HelperFunctions::url_for('/staff/book/index.php'));
	}

	// bug
	$book = new App\Entities\Book(\App\Entities\Book::getBookObj($books));

	$lists = \App\Entities\Book::getLists();
	$genres = $lists['genres'];
	$categories = $lists['categories'];
	$editions = $lists['editions'];
	$authors = $lists['authors'];
	$publishers = $lists['publishers'];

	if (count($book->authors) > 0) {
		$author = \App\Entities\BookAuthor::fetchLastAuthor($book->authors[count($book->authors)-1]);
	}

	if (count($book->publishers) > 0) {
		$publisher = \App\Entities\BookPublisher::fetchLastPublisher($book->publishers[count($book->publishers)-1]);
	}

// View books SQL
} else if (App\Functions\HelperFunctions::is_get_request()) {
	$books = \App\Entities\Book::fetchAll();
}
$count = 0;

///////////////////// Header //////////////////////////////////////
$response = new \App\Response(PROJECT_PATH . '\\views\\staff');
$response->setView('shared\\header.php');
$response->setVars(['page_title'=>$page_title, 'page_heading'=>$page_heading]);
$response->send();

///////////////////// View Books //////////////////////////////////

if(!isset($bookId) && App\Functions\HelperFunctions::is_get_request()) {
	$response->setView('books\\ViewBooks.php');
	$response->setVars(['books'=>$books, 'count'=>$count, 'formatter'=>$formatter]);
	$response->send();
}
///////////////////// Edit Books /////////////////////////////////////
elseif($bookId >= 0 && isset($bookId)) {
	$response->setView('books\\BookForm.php');
	$response->setVars([
		'book'=>$book,
		'bookId'=>$bookId,
		'action'=>$action,
		'genres'=>$genres,
		'editions'=>$editions,
		'categories'=>$categories,
		'authors'=>$authors,
		'publishers'=>$publishers
	]);
	$response->send();
}

$response->setView('shared\\footer.php');
$response->send();