<h2>Books</h2>
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