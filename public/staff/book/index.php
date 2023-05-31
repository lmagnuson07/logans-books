<?php
/**
 * @var $db
 * @var $twig
 */
// setup
















die();
$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
require_once('../../../private/initialize.php');

//if(!isset($page_title)) { $page_title = 'Logan\'s Books'; }
if(!isset($page_heading)) { $page_heading = 'Logan\'s Books'; }
$page_title = "Book CRUD";

/* DEPENDENCY */
$bookGateway = new \App\Entities\Book();
$bookGateway->setDefaults();
$bookTransactions = new \App\Transactions\BookTransactions($bookGateway);
$response = new \App\Response(PROJECT_PATH . '\\views\\staff');

/* CONTROLLER */
$bookId = $_GET['id'] ?? null;
$action = $_SERVER['PHP_SELF'];
// Submit new book
if (App\Functions\HelperFunctions::is_post_request()) {
	if(isset($bookId)) $bookId = null;
		$book = new \App\Entities\Book($_POST['book']);

		// Fix to read from session data.
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
} elseif (App\Functions\HelperFunctions::is_get_request()) {
	$books = \App\Entities\Book::fetchAll();
}

///////////////////// Header //////////////////////////////////////
$response->setView('shared\\header.php');
$response->setVars(['page_title'=>$page_title, 'page_heading'=>$page_heading]);
$response->send();

///////////////////// View Books //////////////////////////////////

if(!isset($bookId) && App\Functions\HelperFunctions::is_get_request()) {
//	$response->setView('books\\ViewBooks.php');
//	$response->setVars(['books'=>$books, 'count'=>$count, 'formatter'=>$formatter]);
//	$response->send();
	$template = $twig->load('staff/books/ViewBook.twig');
	$return =  $template->render([
		'books'=>$books,
		'editUrl'=>\App\Functions\HelperFunctions::url_for('staff/book/index.php?id='),
		'staffUrl'=>\App\Functions\HelperFunctions::url_for('/staff/')
	]);
	echo $return;
}
///////////////////// Edit Books /////////////////////////////////////
elseif($bookId >= 0 && isset($bookId)) {
//	$response->setView('books\\BookForm.php');
//	$response->setVars([
//		'book'=>$book,
//		'bookId'=>$bookId,
//		'action'=>$action,
//		'genres'=>$genres,
//		'editions'=>$editions,
//		'categories'=>$categories,
//		'authors'=>$authors,
//		'publishers'=>$publishers
//	]);
//	$response->send();
	$template = $twig->load('staff/books/BookForm.twig');
	$return =  $template->render([
		'book'=>$book,
		'booksUrl'=>App\Functions\HelperFunctions::url_for('/staff/book/'),
		'bookId'=>$bookId,
		'action'=>$action,
		'genres'=>$genres,
		'editions'=>$editions,
		'categories'=>$categories,
		'authors'=>$authors,
		'publishers'=>$publishers,
		'author'=>$author,
		'publisher'=>$publisher,
	]);
	echo $return;
}

/* FINISHED */
$response->setView('shared\\footer.php');
$response->send();