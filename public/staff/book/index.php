<?php
/**
 * @var $db
 */
// setup
$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
require_once('../../../private/initialize.php');

$page_title = "Book CRUD";
$bookId = $_GET['id'] ?? null;
// SQL
// Submit new book
if (App\Functions\HelperFunctions::is_post_request()) {
	if(isset($bookId)) $bookId = null;
	try {
		$book = new \App\Entities\Book($_POST['book']);

		$db->beginTransaction();
		// Fix to read from session data.
		// Insert the book
		if($book->id === 0) {
			$statement = $db->prepare(
				'INSERT INTO book (current_price,qty_in_stock,qty_on_order,number_of_pages,title,tagline,format,language,synopsis,cover_image_url,is_available)
							VALUES (:current_price,:qty_in_stock,:qty_on_order,:number_of_pages,:title,:tagline,:format,:language,:synopsis,:cover_image_url,:is_available)'
			);
			foreach($book as $k=>$v) {
				if ($k !== 'id' && $k !== 'genres' && $k !== 'categories' && $k !== 'editions' && $k !== 'authors' && $k !== 'publishers') {
					$statement->bindValue(":$k", App\Functions\HelperFunctions::h($v));
				}
			}
			$statement->execute();
			$newBookId = (int)$db->lastInsertId();

			// Insert into Book Genre Details
			if (isset($book->genres) && !empty($book->genres)) {
				$rowCount = count($book->genres);
				$insertData = [];
				foreach($book->genres as $r){
					$insertData[] = $newBookId;
					$insertData[] = (int)App\Functions\HelperFunctions::h($r);
				}
				$values = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";

				$statement = $db->prepare(
					"INSERT INTO bookgenredetail (book_id, genre_id)
							VALUES $values"
				);
				$statement->execute($insertData);
			}

			// Insert into Book Category Details
			if (isset($book->categories) && !empty($book->categories)) {
				$rowCount = count($book->categories);
				$insertData = [];
				foreach($book->categories as $r){
					$insertData[] = $newBookId;
					$insertData[] = (int)App\Functions\HelperFunctions::h($r);
				}
				$values = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";

				$statement = $db->prepare(
					"INSERT INTO bookcategorydetail (book_id, category_id)
							VALUES $values"
				);
				$statement->execute($insertData);
			}

			// Insert into Book Edition Details
			if (isset($book->editions) && !empty($book->editions)) {
				$rowCount = count($book->editions);
				$insertData = [];
				foreach($book->editions as $r){
					$insertData[] = $newBookId;
					$insertData[] = (int)App\Functions\HelperFunctions::h($r);
				}
				$values = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";

				$statement = $db->prepare(
					"INSERT INTO bookeditiondetail (book_id, edition_id)
							VALUES $values"
				);
				$statement->execute($insertData);
			}

			// Insert into Book Author Details
			if (isset($book->authors) && !empty($book->authors)) {
				$rowCount = count($book->authors);
				$insertData = [];
				foreach($book->authors as $r){
					$insertData[] = $newBookId;
					$insertData[] = (int)App\Functions\HelperFunctions::h($r);
				}
				$values = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";

				$statement = $db->prepare(
					"INSERT INTO bookauthordetail (book_id, author_id)
							VALUES $values"
				);
				$statement->execute($insertData);
			}

			// Insert into Book Publisher Details
			if (isset($book->publishers) && !empty($book->publishers)) {
				$rowCount = count($book->publishers);
				$insertData = [];
				foreach($book->publishers as $r){
					$insertData[] = $newBookId;
					$insertData[] = (int)App\Functions\HelperFunctions::h($r);
				}
				$values = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";

				$statement = $db->prepare(
					"INSERT INTO bookpublisherdetail (book_id, publisher_id)
							VALUES $values"
				);
				$statement->execute($insertData);
			}
		}
		// Update a book:
		elseif ($book->id > 0) {
			// Check if the book exists before performing update.
			$statement = $db->prepare(
				'UPDATE book SET current_price=:current_price,qty_in_stock=:qty_in_stock,qty_on_order=:qty_on_order,number_of_pages=:number_of_pages,
                title=:title,tagline=:tagline,format=:format,language=:language,synopsis=:synopsis,cover_image_url=:cover_image_url,is_available=:is_available
            	WHERE id=:id LIMIT 1'
			);
			foreach ($book as $k=>$v) {
				if ($k == 'is_available') {
					$statement->bindValue(":$k", App\Functions\HelperFunctions::h((int)$v));
				}
				elseif ($k !== 'genres' && $k !== 'categories' && $k !== 'editions' && $k !== 'authors' && $k !== 'publishers') {
					$statement->bindValue(":$k", App\Functions\HelperFunctions::h($v));
				}
			}
			$statement->execute();

			// Update Book Genre Details
			$updateList = [];
			$deleteList = [];

			$statement = $db->prepare('SELECT id, genre_id FROM bookgenredetail WHERE book_id = ?');
			$statement->execute([$book->id]);
			$oldRecords = $statement->fetchAll();
			$oldRecordsIds = [];
			foreach($oldRecords as $g) {
				$oldRecordsIds[] = $g->genre_id;
			}

			$newRecords = $book->genres;

			function convertStringToArray ($v) {
				$varInt = (int)$v;
				if($varInt) {
					return $varInt;
				}
			}
			$newRecords = array_map("convertStringToArray", $newRecords);
			foreach($oldRecords as $g) {
				if (!in_array($g->genre_id, $newRecords)) { $deleteList[] = App\Functions\HelperFunctions::h($g->id); }
			}

			foreach($newRecords as $g) {
				if (!in_array($g, $oldRecordsIds)) { $updateList[] = App\Functions\HelperFunctions::h($g); }
			}

			// insert
			if (!empty($updateList)) {
				$placeholders = implode(",",array_map(fn () => "(?,?)", $updateList));
				$values = explode(",",implode(",$book->id,", $updateList).",$book->id");

				$statement = $db->prepare("INSERT INTO bookgenredetail (genre_id, book_id) VALUES " . $placeholders);
				$statement->execute($values);
			}

			// delete
			if (!empty($deleteList)) {
				$placeholders = implode(",",array_map(fn () => "?", $deleteList)) . ")";

				$statement = $db->prepare("DELETE FROM bookgenredetail WHERE id IN ( " . $placeholders);
				$statement->execute($deleteList);
			}

			// Update Book Category Details
			$updateList = [];
			$deleteList = [];

			$statement = $db->prepare('SELECT id, category_id FROM bookcategorydetail WHERE book_id = ?');
			$statement->execute([$book->id]);
			$oldRecords = $statement->fetchAll();
			$oldRecordsIds = [];
			foreach($oldRecords as $g) {
				$oldRecordsIds[] = $g->category_id;
			}

			$newRecords = $book->categories;
			$newRecords = array_map("convertStringToArray", $newRecords);
			foreach($oldRecords as $g) {
				if (!in_array($g->category_id, $newRecords)) { $deleteList[] = App\Functions\HelperFunctions::h($g->id); }
			}

			foreach($newRecords as $g) {
				if (!in_array($g, $oldRecordsIds)) { $updateList[] = App\Functions\HelperFunctions::h($g); }
			}

			// insert
			if (!empty($updateList)) {
				$placeholders = implode(",",array_map(fn () => "(?,?)", $updateList));
				$values = explode(",",implode(",$book->id,", $updateList).",$book->id");

				$statement = $db->prepare("INSERT INTO bookcategorydetail (category_id, book_id) VALUES " . $placeholders);
				$statement->execute($values);
			}

			// delete
			if (!empty($deleteList)) {
				$placeholders = implode(",",array_map(fn () => "?", $deleteList)) . ")";

				$statement = $db->prepare("DELETE FROM bookcategorydetail WHERE id IN (" . $placeholders);
				$statement->execute($deleteList);
			}

			// Update Book Edition Details
			$updateList = [];
			$deleteList = [];

			$statement = $db->prepare('SELECT id, edition_id FROM bookeditiondetail WHERE book_id = ?');
			$statement->execute([$book->id]);
			$oldRecords = $statement->fetchAll();
			$oldRecordsIds = [];
			foreach($oldRecords as $g) {
				$oldRecordsIds[] = $g->edition_id;
			}

			$newRecords = $book->editions;
			$newRecords = array_map("convertStringToArray", $newRecords);
			foreach($oldRecords as $g) {
				if (!in_array($g->edition_id, $newRecords)) { $deleteList[] = App\Functions\HelperFunctions::h($g->id); }
			}

			foreach($newRecords as $g) {
				if (!in_array($g, $oldRecordsIds)) { $updateList[] = App\Functions\HelperFunctions::h($g); }
			}

			// insert
			if (!empty($updateList)) {
				$placeholders = implode(",",array_map(fn () => "(?,?)", $updateList));
				$values = explode(",",implode(",$book->id,", $updateList).",$book->id");

				$statement = $db->prepare("INSERT INTO bookeditiondetail (edition_id, book_id) VALUES " . $placeholders);
				$statement->execute($values);
			}

			// delete
			if (!empty($deleteList)) {
				$placeholders = implode(",",array_map(fn () => "?", $deleteList)) . ")";

				$statement = $db->prepare("DELETE FROM bookeditiondetail WHERE id IN (" . $placeholders);
				$statement->execute($deleteList);
			}

			// Update Book Author Details
			$updateList = [];
			$deleteList = [];

			$statement = $db->prepare('SELECT id, author_id FROM bookauthordetail WHERE book_id = ?');
			$statement->execute([$book->id]);
			$oldRecords = $statement->fetchAll();
			$oldRecordsIds = [];
			foreach($oldRecords as $g) {
				$oldRecordsIds[] = $g->author_id;
			}

			$newRecords = $book->authors;
			$newRecords = array_map("convertStringToArray", $newRecords);
//			foreach($oldRecords as $g) {
//				if (!empty($newRecords)) {
//					if (!in_array($g->author_id, $newRecords)) { $deleteList[] = h($g->id); }
//				}
//			}

			foreach($newRecords as $g) {
				if (!in_array($g, $oldRecordsIds)) { $updateList[] = App\Functions\HelperFunctions::h($g); }
			}

			// insert
			if (!empty($updateList)) {
				$placeholders = implode(",",array_map(fn () => "(?,?)", $updateList));
				$values = explode(",",implode(",$book->id,", $updateList).",$book->id");

				$statement = $db->prepare("INSERT INTO bookauthordetail (author_id, book_id) VALUES " . $placeholders);
				$statement->execute($values);
			}

			// delete (cant delete right now since existing authors are disabled on the form)
//			if (!empty($deleteList)) {
//				$placeholders = implode(" and ",array_map(fn () => "?", $deleteList));
//
//				$statement = $db->prepare("DELETE FROM bookauthordetail WHERE id = " . $placeholders);
//				$statement->execute($deleteList);
//			}

			// Update Book Publisher Details
			$updateList = [];
			$deleteList = [];

			$statement = $db->prepare('SELECT book_id, publisher_id FROM bookpublisherdetail WHERE book_id = ?');
			$statement->execute([$book->id]);
			$oldRecords = $statement->fetchAll();
			$oldRecordsIds = [];
			foreach($oldRecords as $g) {
				$oldRecordsIds[] = $g->publisher_id;
			}

			$newRecords = $book->publishers;
			$newRecords = array_map("convertStringToArray", $newRecords);
//			foreach($oldRecords as $g) {
//				if (!empty($newRecords)) {
//					if (!in_array($g->publisher_id, $newRecords)) { $deleteList[] = h($g->publisher_id); $deleteList[] = h($g->book_id); }
//				}
//			}

			foreach($newRecords as $g) {
				if (!in_array($g, $oldRecordsIds)) { $updateList[] = App\Functions\HelperFunctions::h($g); }
			}

			// insert
			if (!empty($updateList)) {
				$placeholders = implode(",",array_map(fn () => "(?,?)", $updateList));
				$values = explode(",",implode(",$book->id,", $updateList).",$book->id");

				$statement = $db->prepare("INSERT INTO bookpublisherdetail (publisher_id, book_id) VALUES " . $placeholders);
				$statement->execute($values);
			}

			// delete (cant delete right now since existing publishers are disabled on the form)
//			if (!empty($deleteList)) {
//				$placeholders = implode(" and ",array_map(fn () => "?", $deleteList));
//
//				$statement = $db->prepare("DELETE FROM bookpublisherdetail WHERE id = " . $placeholders);
//				$statement->execute($deleteList);
//			}
		}
		$db->commit();
	} catch (\Throwable $e) {
		if ($db->inTransaction()) {
			$db->rollBack();
		}
	}
}
// Create new Book
// TODO: Move sql to class and refactor to remove code duplication.
if ((int)$bookId === 0 && !is_null($bookId)) {
	// TODO: Refactor to store the genres, categories, and editions on an object
	$genres = \App\Entities\BookGenre::fetchColsOrderBy(cols: ['id', 'name'], orderBy: ['name']);
	$categories = \App\Entities\BookCategory::fetchColsOrderBy(cols: ['id', 'name'], orderBy: ['name']);
	$editions = \App\Entities\BookEdition::fetchColsOrderBy(cols: ['id', 'name'], orderBy: ['name']);
	$authors = \App\Entities\BookAuthor::fetchColsOrderBy(cols: ['id', 'first_name', 'last_name'], orderBy: ['first_name']);
	$publishers = \App\Entities\BookPublisher::fetchColsOrderBy(cols: ['id', 'name'], orderBy: ['name']);

	// Cant do default properties on the class in the constructor because of PDO FETCH_CLASS.
	// TODO: Add a method on the book class that will be for setting up default properties.
	$args['id'] = 0;
	$args['current_price'] = 0;
	$args['qty_in_stock'] = 0;
	$args['qty_on_order'] = 0;
	$args['title'] = '';
	$args['tagline'] = '';
	$args['synopsis'] = '';
	$args['number_of_pages'] = 0;
	$args['format'] = '';
	$args['language'] = '';
	$args['cover_image_url'] = '';
	$args['is_available'] = true;
	$args['genres'] = [];
	$args['categories'] = [];
	$args['editions'] = [];
	$args['authors'] = [];
	$args['publishers'] = [];

	$book = new App\Entities\Book($args);

// Edit books SQL
} elseif (isset($bookId)) {
	// Genres
	$genres = \App\Entities\BookGenre::fetchColsOrderBy(cols: ['id', 'name'], orderBy: ['name']);
	$categories = \App\Entities\BookCategory::fetchColsOrderBy(cols: ['id', 'name'], orderBy: ['name']);
	$editions = \App\Entities\BookEdition::fetchColsOrderBy(cols: ['id', 'name'], orderBy: ['name']);
	$authors = \App\Entities\BookAuthor::fetchColsOrderBy(cols: ['id', 'first_name', 'last_name'], orderBy: ['first_name']);
	$publishers = \App\Entities\BookPublisher::fetchColsOrderBy(cols: ['id', 'name'], orderBy: ['name']);

	// Many-to-many relationships
	$qry = "SELECT b.id, b.current_price, b.qty_in_stock, b.qty_on_order, 
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
	WHERE b.id = :id";

	$statement = $db->prepare($qry);
	$statement->bindValue(':id', $bookId);

	$statement->execute();
	$book = $statement->fetchAll();
	// TODO: Put query code into a class and make the method return false, and just check if book is false instead
	// Catches errors if an id that doesn't exist is typed into url.
	if (empty($book)) {
		// For books that are recently added and have no many - many relationships
		$qry = "SELECT b.id, b.current_price, b.qty_in_stock, b.qty_on_order, 
			b.title, b.tagline, b.synopsis, b.number_of_pages, b.format, 
			b.language, b.cover_image_url, b.is_available
		FROM book b
		WHERE b.id = :id";

		$statement = $db->prepare($qry);
		$statement->bindValue(':id', $bookId);

		$statement->execute();
		$book = $statement->fetchAll();

		if (empty($book)) {
			App\Functions\HelperFunctions::redirect_to(App\Functions\HelperFunctions::url_for('/staff/book/index.php'));
		}
	}

	$bookObj = [];
	foreach($book as $i=>$b) {
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
		// BookGenre
		if(!empty($bookObj['genres'])) {
				if (!in_array($b->genre_id, $bookObj['genres'])) {
					$bookObj['genres'][] = $b->genre_id;
				}
		} elseif(isset($b->genre_id)) {
			$bookObj['genres'][] = $b->genre_id;
		}
		// Categories
		if(!empty($bookObj['categories'])) {
				if (!in_array($b->category_id, $bookObj['categories'])) {
					$bookObj['categories'][] = $b->category_id;
				}
		} elseif(isset($b->category_id)) {
			$bookObj['categories'][] = $b->category_id;
		}
		// Editions
		if(!empty($bookObj['editions'])) {
				if (!in_array($b->edition_id, $bookObj['editions'])) {
					$bookObj['editions'][] = $b->edition_id;
				}
		} elseif(isset($b->edition_id)) {
			$bookObj['editions'][] = $b->edition_id;
		}
		// Authors
		if(!empty($bookObj['authors'])) {
				if (!in_array($b->author_id, $bookObj['authors'])) {
					$bookObj['authors'][] = $b->author_id;
				}
		} elseif(isset($b->author_id)) {
			$bookObj['authors'][] = $b->author_id;
		}
		// Publisher
		if(!empty($bookObj['publishers'])) {
				if (!in_array($b->publisher_id, $bookObj['publishers'])) {
					$bookObj['publishers'][] = $b->publisher_id;
				}
		} elseif(isset($b->publisher_id)) {
			$bookObj['publishers'][] = $b->publisher_id;
		}
	}
	$book = new App\Entities\Book($bookObj);

	// Last author entered
	$where = (count($book->authors) > 0) ? " WHERE id = :id" : "";
	$qry = "SELECT id, first_name, last_name
		FROM bookauthor" . $where;
	$statement = $db->prepare($qry);
	if (!empty($where)) { $statement->bindValue(':id', $book->authors[count($book->authors)-1]); }

	$statement->execute();
	$statement->setFetchMode(PDO::FETCH_CLASS, 'App\\Entities\\BookAuthor');
	$author = $statement->fetch();

	// Last publisher entered
	$where = (count($book->authors) > 0) ? " WHERE id = :id" : "";
	$qry = "SELECT id, name
		FROM bookpublisher" . $where;
	$statement = $db->prepare($qry);
	if (!empty($where)) { $statement->bindValue(':id', $book->publishers[count($book->publishers)-1]); }

	$statement->execute();
	$statement->setFetchMode(PDO::FETCH_CLASS, 'App\\Entities\\BookPublisher');
	$publisher = $statement->fetch();

// View books SQL
} else if (App\Functions\HelperFunctions::is_get_request()) {
	$qry = "SELECT * FROM book";
	$statement = $db->prepare($qry);

	$statement->execute();
	$books = $statement->fetchAll(PDO::FETCH_CLASS, 'App\\Entities\\Book');
}
$count = 0;

require_once('../../../private/shared/staff_header.php');
?>
<h2>Books</h2>
<!---------------- View Books-------------------->
<?php if(!isset($bookId) && App\Functions\HelperFunctions::is_get_request()): ?>
<p><a href="<?php echo App\Functions\HelperFunctions::url_for('/staff/'); ?>">&laquo; Go back to Staff home page</a></p>
<p><a href="<?php echo App\Functions\HelperFunctions::url_for('/staff/book/index.php?id=0'); ?>">Create a new book &raquo;</a></p>
<p>List of books</p>
<table>
	<thead>
	<tr>
		<th>&nbsp;</th>
		<th>ID</th>
		<th>Available</th>
		<th>Title</th>
		<th>Current Price</th>
		<th>Qty In Stock</th>
		<th>Qty On Order</th>
		<th>Pages</th>
		<th>Language</th>
		<th>Format</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>
	</thead>
	<tbody>
		<?php
		foreach($books as $b) {
			$count++;
			echo "<tr>";
			echo "<td>" . $count . "</td >";
			echo "<td>" . $b->id . "</td >";
			echo "<td>" . ($b->is_available ? "Y" : "N") . "</td >";
			echo "<td>" . $b->title . "</td >";
			echo "<td>" . $formatter->format($b->current_price) . "</td >";
			echo "<td>" . $b->qty_in_stock . "</td >";
			echo "<td>" . $b->qty_on_order . "</td >";
			echo "<td>" . $b->number_of_pages . "</td >";
			echo "<td>" . $b->language . "</td >";
			echo "<td>" . $b->format . "</td >";
			echo "<td><a href=" . App\Functions\HelperFunctions::url_for("staff/book/index.php?id=" . App\Functions\HelperFunctions::h(App\Functions\HelperFunctions::u($b->id))) . ">Edit</a></td>";
			echo "<td><a href=\"#\">Deactivate</a ></td >";
			echo "</tr>";
		}
		?>
	</tbody>
</table>
<!-- ----------------------------------------->
<!-- Edit Book ------------------------------->
<?php elseif($bookId >= 0 && isset($bookId)): ?>
<a href="<?php echo App\Functions\HelperFunctions::url_for('/staff/book/'); ?>">&laquo; Go back to Books</a>
<h2>Book Form</h2>
<!--TODO: Refactor to use jquery and ajax instead of an id of 0-->
<h3><?php echo $book->title . " - [Book ID: " .  $bookId . "]"; ?></h3>
	<form class="edit-book-form" action="<?php echo App\Functions\HelperFunctions::url_for("/staff/book/index.php?id=" . App\Functions\HelperFunctions::u(App\Functions\HelperFunctions::h($bookId))); ?>" method="post">
<!--		TODO: Convert hidden inputs to ajax calls using jquery, or store the id in the session data-->
		<input type="hidden" name="book[id]" value="<?php echo $book->id; ?>" />
		<div>
			<label for="current_price">Current Price:</label>
			<input type="number" step="any" min="0.0000" id="current_price" name="book[current_price]" value="<?php echo $book->current_price; ?>" />
		</div>
		<div>
			<label for="qty_in_stock">Quantity In Stock:</label>
			<input type="number" step="1" id="qty_in_stock" name="book[qty_in_stock]" value="<?php echo $book->qty_in_stock; ?>" />
		</div>
		<div>
			<label for="qty_on_order">Quantity On Order:</label>
			<input type="number" step="1" id="qty_on_order" name="book[qty_on_order]" value="<?php echo $book->qty_on_order; ?>" />
		</div>
		<div>
			<label for="number_of_pages">Number Of Pages:</label>
			<input type="number" step="1" id="number_of_pages" name="book[number_of_pages]" value="<?php echo $book->number_of_pages; ?>" />
		</div>
		<div>
			<label for="title">Title:</label>
			<input type="text" id="title" name="book[title]" value="<?php echo $book->title; ?>" />
		</div>
		<div>
			<label for="tagline">Tagline:</label>
			<input type="text" id="tagline" name="book[tagline]" value="<?php echo $book->tagline; ?>" />
		</div>
		<div>
			<label for="format">Format:</label>
			<select name="book[format]" id="format">
				<option value="Hardcover" <?php echo $book->format == "Hardcover" ? "selected" : ""; ?>>Hardcover</option>
				<option value="Softcover" <?php echo $book->format == "Softcover" ? "selected" : ""; ?>>Softcover</option>
			</select>
		</div>
<!--		TODO: Add languages programmatically to the database and add a datalist to select the language. -->
		<div>
			<label for="language">Language:</label>
			<input type="text" id="language" name="book[language]" value="<?php echo $book->language; ?>" />
		</div>
		<div>
			<label for="synopsis">Synopsis:</label>
			<textarea id="synopsis" name="book[synopsis]"><?php echo trim($book->synopsis); ?></textarea>
		</div>
		<div>
			<label for="cover_image_url">Cover Image URL:</label>
			<input type="text" id="cover_image_url" name="book[cover_image_url]" value="<?php echo $book->cover_image_url; ?>" />
		</div>
		<div class="radio-buttons">
			<label>Available:</label>
			<div>
				<label for="is_availableY">Yes</label>
				<input type="radio" id="is_availableY" name="book[is_available]" value="1" <?php echo $book->is_available ? "checked" : ""; ?> />
			</div>
			<div>
				<label for="is_availableN">No</label>
				<input type="radio" id="is_availableN" name="book[is_available]" value="0" <?php echo !$book->is_available ? "checked" : ""; ?>/>
			</div>
		</div>
<!--		genre checkbox-->
		<div class="book-checkboxes book-genre-checkboxes">
			<h3>Genres</h3>
		<?php foreach($genres as $g){
			$checked = (in_array($g->id, $book->genres)) ? "checked" : "";
				echo "<div>";
					echo "<label for=\"genre$g->id\">$g->name</label>";
					echo "<input type=\"checkbox\" id=\"genre$g->id\" value=\"$g->id\" name='book[genres][]' $checked />";
				echo "</div>";
		}
		?>
		</div>
		<!--		edition checkbox-->
		<div class="book-checkboxes">
			<h3>Editions</h3>
			<?php foreach($editions as $e){
				$checked = (in_array($e->id, $book->editions)) ? "checked" : "";
				echo "<div>";
				echo "<label for=\"edition$e->id\">$e->name</label>";
				echo "<input type=\"checkbox\" id=\"edition$e->id\" value=\"$e->id\" name='book[editions][]' $checked />";
				echo "</div>";
			}
			?>
		</div>
<!--		category checkbox-->
		<div class="book-checkboxes">
			<h3>Categories</h3>
		<?php foreach($categories as $c){
			$checked = (in_array($c->id, $book->categories)) ? "checked" : "";
			echo "<div>";
			echo "<label for=\"category$c->id\">$c->name</label>";
			echo "<input type=\"checkbox\" id=\"category$c->id\" value=\"$c->id\" name='book[categories][]' $checked />";
			echo "</div>";
		}
		?>
		</div>
<!--		TODO: Implement a way for the user to be able to select more than one author without using checkboxes (jquery)-->
<!--		author form (check if exists)-->
		<div>
			<h3>Author</h3>
			<div>
				<label for="author">Select an author from the list</label>
				<select name="book[authors][]" id="author">
					<option value="none">No Author...</option>
					<?php
					foreach($authors as $a) {
						if ($a->id === $author->id) {
							echo "<option value=\"$a->id\" selected disabled>$a->first_name $a->last_name</option>";
						} elseif (in_array($a->id, $book->authors)) {
							echo "<option value=\"$a->id\" disabled>$a->first_name $a->last_name</option>";
						}else {
							echo "<option value=\"$a->id\">$a->first_name $a->last_name</option>";
						}
					}
					?>
				</select>
			</div>
		</div>
<!--		publisher form (check if exists)-->
		<div>
			<h3>Publisher</h3>
			<div>
				<label for="publisher">Select an author from the list</label>
				<select name="book[publishers][]" id="publisher">
					<option value="none">No Publisher...</option>
					<?php
					foreach($publishers as $p) {
						if ($p->id === $publisher->id) {
							echo "<option value=\"$p->id\" selected disabled>$p->name</option>";
						} elseif (in_array($p->id, $book->publishers)) {
							echo "<option value=\"$p->id\" disabled>$p->name</option>";
						}else {
							echo "<option value=\"$p->id\">$p->name</option>";
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="btn-container">
			<button type="submit" name="book_submit">Submit</button>
		</div>
	</form>
<?php endif; ?>
<!-- ----------------------------------------->
<!-- Submit/View Book ------------------------------->

<?php
require_once('../../../private/shared/staff_footer.php');
?>
