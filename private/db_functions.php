<?php

function db_connect() {
	try {
		// FETCH_ASSOC, FETCH_CLASS, default fetch array
		$conn = new PDO('mysql:dbname=logans_books;host=localhost;port:80', DB_USER, DB_PASS, [
			//PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			PDO::ATTR_EMULATE_PREPARES => false, // performance boost. placeholders in other clause. Returns int not string.
		]);
	} catch (\PDOException $e) {
		throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}
//	if ($conn->connect_errno) {
//		$msg = "Database connection failed: ";
//		//$msg .= $conn->connect_error;
//		//$msg .= " ($conn->connect_errno)";
//		exit($msg);
//	}
	return $conn;
}

function db_disconnect($conn) {
	$conn?->close();
}