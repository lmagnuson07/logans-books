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
