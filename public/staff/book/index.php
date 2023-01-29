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
				$placeHolders = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";
				\App\Shared\BasicQueries::insertCols(cols: ['book_id', 'genre_id'], placeHolders: $placeHolders, tableName: "bookgenredetail", insertData: $insertData);
			}

			// Insert into Book Category Details
			if (isset($book->categories) && !empty($book->categories)) {
				$rowCount = count($book->categories);
				$insertData = [];
				foreach($book->categories as $r){
					$insertData[] = $newBookId;
					$insertData[] = (int)App\Functions\HelperFunctions::h($r);
				}
				$placeHolders = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";
				\App\Shared\BasicQueries::insertCols(cols: ['book_id', 'category_id'], placeHolders: $placeHolders, tableName: "bookcategorydetail", insertData: $insertData);
			}

			// Insert into Book Edition Details
			if (isset($book->editions) && !empty($book->editions)) {
				$rowCount = count($book->editions);
				$insertData = [];
				foreach($book->editions as $r){
					$insertData[] = $newBookId;
					$insertData[] = (int)App\Functions\HelperFunctions::h($r);
				}
				$placeHolders = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";
				\App\Shared\BasicQueries::insertCols(cols: ['book_id', 'edition_id'], placeHolders: $placeHolders, tableName: "bookeditiondetail", insertData: $insertData);
			}

			// Insert into Book Author Details
			if (isset($book->authors) && !empty($book->authors)) {
				$rowCount = count($book->authors);
				$insertData = [];
				foreach($book->authors as $r){
					$insertData[] = $newBookId;
					$insertData[] = (int)App\Functions\HelperFunctions::h($r);
				}
				$placeHolders = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";
				\App\Shared\BasicQueries::insertCols(cols: ['book_id', 'author_id'], placeHolders: $placeHolders, tableName: "bookauthordetail", insertData: $insertData);
			}

			// Insert into Book Publisher Details
			if (isset($book->publishers) && !empty($book->publishers)) {
				$rowCount = count($book->publishers);
				$insertData = [];
				foreach($book->publishers as $r){
					$insertData[] = $newBookId;
					$insertData[] = (int)App\Functions\HelperFunctions::h($r);
				}
				$placeHolders = "(" . implode('),(', array_fill(0, $rowCount, '?,?')) . ")";
				\App\Shared\BasicQueries::insertCols(cols: ['book_id', 'publisher_id'], placeHolders: $placeHolders, tableName: "bookpublisherdetail", insertData: $insertData);
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

			$oldRecords = \App\Shared\BasicQueries::fetchBridgingTableColsById(cols: ['id', 'genre_id'], id: $book->id, tableName: "bookgenredetail", targetId: "book_id");
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
				$insertData = explode(",",implode(",$book->id,", $updateList).",$book->id");
				\App\Shared\BasicQueries::insertCols(cols: ['genre_id', 'book_id'], placeHolders: $placeholders, tableName: "bookgenredetail", insertData: $insertData);
			}

			// delete
			if (!empty($deleteList)) {
				$placeholders = implode(",",array_map(fn () => "?", $deleteList));
				\App\Shared\BasicQueries::deleteRecords(placeHolders: $placeholders, tableName: "bookgenredetail", ids: $deleteList);
			}

			// Update Book Category Details
			$updateList = [];
			$deleteList = [];

			$oldRecords = \App\Shared\BasicQueries::fetchBridgingTableColsById(cols: ['id', 'category_id'], id: $book->id, tableName: "bookcategorydetail", targetId: "book_id");
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
				$insertData = explode(",",implode(",$book->id,", $updateList).",$book->id");
				\App\Shared\BasicQueries::insertCols(cols: ['category_id', 'book_id'], placeHolders: $placeholders, tableName: "bookcategorydetail", insertData: $insertData);
			}

			// delete
			if (!empty($deleteList)) {
				$placeholders = implode(",",array_map(fn () => "?", $deleteList)) . ")";
				\App\Shared\BasicQueries::deleteRecords(placeHolders: $placeholders, tableName: "bookcategorydetail", ids: $deleteList);
			}

			// Update Book Edition Details
			$updateList = [];
			$deleteList = [];

			$oldRecords = \App\Shared\BasicQueries::fetchBridgingTableColsById(cols: ['id', 'edition_id'], id: $book->id, tableName: "bookeditiondetail", targetId: "book_id");
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
				$insertData = explode(",",implode(",$book->id,", $updateList).",$book->id");
				\App\Shared\BasicQueries::insertCols(cols: ['edition_id', 'book_id'], placeHolders: $placeholders, tableName: "bookeditiondetail", insertData: $insertData);
			}

			// delete
			if (!empty($deleteList)) {
				$placeholders = implode(",",array_map(fn () => "?", $deleteList)) . ")";
				\App\Shared\BasicQueries::deleteRecords(placeHolders: $placeholders, tableName: "bookeditiondetail", ids: $deleteList);
			}

			// Update Book Author Details
			$updateList = [];
			$deleteList = [];

			$oldRecords = \App\Shared\BasicQueries::fetchBridgingTableColsById(cols: ['id', 'author_id'], id: $book->id, tableName: "bookauthordetail", targetId: "book_id");
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
				$insertData = explode(",",implode(",$book->id,", $updateList).",$book->id");
				\App\Shared\BasicQueries::insertCols(cols: ['author_id', 'book_id'], placeHolders: $placeholders, tableName: "bookauthordetail", insertData: $insertData);
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

			$oldRecords = \App\Shared\BasicQueries::fetchBridgingTableColsById(cols: ['book_id', 'publisher_id'], id: $book->id, tableName: "bookpublisherdetail", targetId: "book_id");
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
				$insertData = explode(",",implode(",$book->id,", $updateList).",$book->id");
				\App\Shared\BasicQueries::insertCols(cols: ['publisher_id', 'book_id'], placeHolders: $placeholders, tableName: "bookpublisherdetail", insertData: $insertData);
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
} else if (App\Functions\HelperFunctions::is_get_request()) {
	$books = \App\Entities\Book::fetchAll();
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
