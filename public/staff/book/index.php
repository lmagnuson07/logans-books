<?php
require_once('../../../private/initialize.php');

$page_title = "Book CRUD";
require_once('../../../private/shared/staff_header.php');
?>
<h2>Books</h2>
<a href="<?php echo url_for('/staff/'); ?>">&laquo; Go back to Staff home page</a>
<p>Create a new book >></p>
<p>List of books</p>
<form action="">
	<input type="text" placeholder="Enter search"/>
</form>
<table border="1">
	<thead>
	<tr>
		<th>Item One</th>
		<th>Item Two</th>
		<th>Item Three</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>Data One</td>
		<td>Data Two</td>
		<td>Data Three</td>
		<td><a href="#">View</a></td>
		<td><a href="#">Edit</a></td>
		<td><a href="#">Delete</a></td>
	</tr>
	</tbody>
</table>
<?php
require_once('../../../private/shared/staff_footer.php');
?>
