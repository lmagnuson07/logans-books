<?php
require_once('../../private/initialize.php');

require_once('../../private/shared/staff_header.php');

if (isset($_POST['import_csv_btn'])) {
	var_dump($_POST['import_csv_btn']);

	try {
		// read the csv
//		$filename = CSV_DOCUMENT_PATH . "2022-2_SubdivisionCodes.csv";
//		$filename = CSV_DOCUMENT_PATH . "2022-2_UNLOCODE_CodeListPart1.csv";
		$filename = CSV_DOCUMENT_PATH . "2022-2_UNLOCODE_CodeListPart2.csv";
//		$filename = CSV_DOCUMENT_PATH . "2022-2_UNLOCODE_CodeListPart3.csv";
		$csvFile = new \App\Shared\ParseCsv(fileName: $filename);
		$data = $csvFile->parse();

		print_r($data);
	} catch (Exception $ex) {
		$msg = $ex->getMessage();
		echo "<p>$msg</p>";
	}
}


?>
	<!--	redirect to login page from here if user is not logged in -->
<!--	<h2 class="foo">About This Page <span>Huh</span></h2>-->
<!--	<h3>Wow</h3>-->
<!--	<p>Employees will choose to perform CRUD on Books, Customers, Sales, Purchasing, Receiving, Rentals, Refunds, or Companies.</p>-->
<!--	<input type="text" placeholder="Enter something">-->
	<form action="" method="post">
		<input type="submit" name="import_csv_btn" value="Import CSV">
	</form>
<?php
require_once('../../private/shared/staff_footer.php');
?>