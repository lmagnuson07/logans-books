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
// Edit books SQL
if (isset($bookId)) {
	// TODO: Refactor to store the genres, categories, and editions on an object
	// Genres
	$qry = "SELECT id, name FROM bookgenre ORDER BY name";
	$statement = $db->prepare($qry);

	$statement->execute();
	$genres = $statement->fetchAll(PDO::FETCH_CLASS, 'App\\Entities\\BookGenre');

	// Categories
	$qry = "SELECT id, name FROM bookcategory ORDER BY name";
	$statement = $db->prepare($qry);

	$statement->execute();
	$categories = $statement->fetchAll(PDO::FETCH_CLASS, 'App\\Entities\\BookCategory');

	// Editions
	$qry = "SELECT id, name FROM bookedition ORDER BY name";
	$statement = $db->prepare($qry);

	$statement->execute();
	$editions = $statement->fetchAll(PDO::FETCH_CLASS, 'App\\Entities\\BookEdition');

	// Authors
	$qry = "SELECT id, first_name, last_name FROM bookauthor ORDER BY first_name";
	$statement = $db->prepare($qry);

	$statement->execute();
	$authors = $statement->fetchAll(PDO::FETCH_CLASS, 'App\\Entities\\BookAuthor');

	// Authors
	$qry = "SELECT id, name FROM bookpublisher ORDER BY name";
	$statement = $db->prepare($qry);

	$statement->execute();
	$publishers = $statement->fetchAll(PDO::FETCH_CLASS, 'App\\Entities\\BookPublisher');

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
	$statement->bindValue('id', $bookId);

	$statement->execute();
	$book = $statement->fetchAll();

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
		} else {
			$bookObj['genres'][] = $b->genre_id;
		}
		// Categories
		if(!empty($bookObj['categories'])) {
				if (!in_array($b->category_id, $bookObj['categories'])) {
					$bookObj['categories'][] = $b->category_id;
				}
		} else {
			$bookObj['categories'][] = $b->category_id;
		}
		// Editions
		if(!empty($bookObj['editions'])) {
				if (!in_array($b->edition_id, $bookObj['editions'])) {
					$bookObj['editions'][] = $b->edition_id;
				}
		} else {
			$bookObj['editions'][] = $b->edition_id;
		}
		// Authors
		if(!empty($bookObj['authors'])) {
				if (!in_array($b->author_id, $bookObj['authors'])) {
					$bookObj['authors'][] = $b->author_id;
				}
		} else {
			$bookObj['authors'][] = $b->author_id;
		}
		// Publisher
		if(!empty($bookObj['publishers'])) {
				if (!in_array($b->publisher_id, $bookObj['publishers'])) {
					$bookObj['publishers'][] = $b->publisher_id;
				}
		} else {
			$bookObj['publishers'][] = $b->publisher_id;
		}
	}
	$book = new \App\Entities\Book($bookObj);

	// Last author entered
	$qry = "SELECT id, first_name, last_name
		FROM bookauthor
		WHERE id = :id";
	$statement = $db->prepare($qry);
	if (count($book->authors) > 0) { $statement->bindValue('id', $book->authors[count($book->authors)-1]); }

	$statement->execute();
	$statement->setFetchMode(PDO::FETCH_CLASS, 'App\\Entities\\BookAuthor');
	$author = $statement->fetch();

	// Last publisher entered
	$qry = "SELECT id, name
		FROM bookpublisher
		WHERE id = :id";
	$statement = $db->prepare($qry);
	if (count($book->publishers) > 0) { $statement->bindValue('id', $book->publishers[count($book->publishers)-1]); }

	$statement->execute();
	$statement->setFetchMode(PDO::FETCH_CLASS, 'App\\Entities\\BookPublisher');
	$publisher = $statement->fetch();

// View books SQL
} else {
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
<?php if(!isset($bookId)): ?>
<a href="<?php echo url_for('/staff/'); ?>">&laquo; Go back to Staff home page</a>
<p>Create a new book >></p>
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
			echo "<td><a href=" . url_for("staff/book/index.php?id=" . h(u($b->id))) . ">Edit</a></td>";
			echo "<td><a href=\"#\">Deactivate</a ></td >";
			echo "</tr>";
		}
		?>
	</tbody>
</table>
<!-- ----------------------------------------->
<!-- Edit Book ------------------------------->
<?php elseif($bookId > 0): ?>
<a href="<?php echo url_for('/staff/book/'); ?>">&laquo; Go back to Books</a>
<h2>Book Form</h2>
<h3><?php echo $book->title . " - [Book ID: " .  $bookId . "]"; ?></h3>
	<form class="edit-book-form" action="index.php" method="post">
<!--		TODO: Convert hidden inputs to ajax calls using jquery-->
		<input type="hidden" name="book[id]" value="<?php echo $book->id; ?>" />
		<div>
			<label for="current_price">Current Price:</label>
			<input type="number" step="0.1" id="current_price" name="book[current_price]" value="<?php echo $book->current_price; ?>" />
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
			<label for="title">Title:</label>
			<input type="text" id="title" name="book[title]" value="<?php echo $book->title; ?>" />
		</div>
		<div>
			<label for="tagline">Tagline:</label>
			<input type="text" id="tagline" name="book[tagline]" value="<?php echo $book->tagline; ?>" />
		</div>
		<div>
			<label for="number_of_pages">Number Of Pages:</label>
			<input type="number" step="1" id="number_of_pages" name="book[number_of_pages]" value="<?php echo $book->number_of_pages; ?>" />
		</div>
		<div>
			<label for="format">Format:</label>
			<input type="text" id="format" name="book[format]" value="<?php echo $book->format; ?>" />
		</div>
<!--		todo: Add languages programmatically to the database and add a datalist to select the language. -->
		<div>
			<label for="language">Language:</label>
			<input type="text" id="language" name="book[language]" value="<?php echo $book->language; ?>" />
		</div>
		<div>
			<label for="synopsis">Synopsis:</label>
			<textarea id="synopsis" name="book[synopsis]" value="<?php echo $book->synopsis; ?>"><?php echo trim($book->synopsis); ?></textarea>
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
					echo "<input type=\"checkbox\" id=\"genre$g->id\" value=\"$g->id\" name='genres' $checked />";
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
				echo "<label for=\"category$e->id\">$e->name</label>";
				echo "<input type=\"checkbox\" id=\"category$e->id\" value=\"$e->id\" name='editions' $checked />";
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
			echo "<input type=\"checkbox\" id=\"category$c->id\" value=\"$c->id\" name='categories' $checked />";
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
				<select name="author" id="author">
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
				<select name="publisher" id="publisher">
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
			<button type="submit">Submit</button>
		</div>
	</form>
<?php endif; ?>


<?php
require_once('../../../private/shared/staff_footer.php');
?>
