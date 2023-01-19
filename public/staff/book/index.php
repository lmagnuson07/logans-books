<?php
$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
require_once('../../../private/initialize.php');
$stm = "SELECT * FROM book ";
$statement = $db->prepare($stm);

$statement->execute();

$books = $statement->fetchAll();

$page_title = "Book CRUD";
require_once('../../../private/shared/staff_header.php');
?>
<h2>Books</h2>
<a href="<?php echo url_for('/staff/'); ?>">&laquo; Go back to Staff home page</a>
<p>Create a new book >></p>
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
		<th>&nbsp;</th>
	</tr>
	</thead>
	<tbody>
		<?php
		$count = 0;
		foreach($books as $b) {
			$count++;
			echo "<tr>";
			echo "<td>" . $count . "</td >";
			echo "<td>" . $b['id'] . "</td >";
			echo "<td>" . ($b['is_available'] ? "Y" : "N") . "</td >";
			echo "<td>" . $b['title'] . "</td >";
			echo "<td>" . $formatter->format($b['current_price']) . "</td >";
			echo "<td>" . $b['qty_in_stock'] . "</td >";
			echo "<td>" . $b['qty_on_order'] . "</td >";
			echo "<td>" . $b['number_of_pages'] . "</td >";
			echo "<td>" . $b['language'] . "</td >";
			echo "<td>" . $b['format'] . "</td >";
			echo "<td><a href=\"#\">View</a ></td >";
			echo "<td><a href=\"#\">Edit</a ></td >";
			echo "<td><a href=\"#\">Delete</a ></td >";
			echo "</tr>";
		}
		?>
	</tbody>
</table>
<?php
require_once('../../../private/shared/staff_footer.php');
?>
