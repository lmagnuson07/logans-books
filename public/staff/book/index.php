<?php
// setup
$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
require_once('../../../private/initialize.php');
var_dump($_POST);
$page_title = "Book CRUD";
$bookId = $_GET['id'] ?? null;
// SQL
// Edit books SQL
if (isset($bookId)) {
	$qry = "SELECT * FROM book WHERE id = :id";
	$statement = $db->prepare($qry);

	$statement->bindValue('id', $bookId);

	$statement->execute();
	$statement->setFetchMode(PDO::FETCH_CLASS, 'App\\Entities\\Book');
	$book = $statement->fetch();
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
<a href="<?php echo url_for('/staff/'); ?>">&laquo; Go back to Staff home page</a>
<p>Create a new book >></p>

<!---------------- View Books-------------------->
<?php if(!isset($bookId)): ?>
<p>List of books</p>
<table border="1">
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
			echo "<td><a href=\"index.php?id={$b->id}\">Edit</a></td>";
			echo "<td><a href=\"#\">Deactivate</a ></td >";
			echo "</tr>";
		}
		?>
	</tbody>
</table>
<!-- ----------------------------------------->
<!-- Edit Book ------------------------------->
<?php elseif($bookId > 0): ?>
<h2>Book Form</h2>
	<form action="index.php" method="post">
		<h3><?php echo $book->title . " - [Book ID: " .  $bookId . "]"; ?></h3>
		<?php foreach($book as $k=>$v){
			echo "<input type=\"hidden\" name=\"book[$k]\" value=\"$v\" />";
			if($k != 'id') {
				echo "<div>";
				echo "<label for=\"$k\">" . title_text($k) . ":</label>";
				echo "<input type=\"text\" id=$k name=\"book[$k]\" value=\"$v\"/>";
				echo "</div>";
			}
		}
		?>
		<button type="submit">Submit</button>
	</form>
<?php endif; ?>


<?php
require_once('../../../private/shared/staff_footer.php');
?>
