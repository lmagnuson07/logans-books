<?php
try {
	if (!file_exists(__DIR__ . '/../private/initialize.php')) {
		throw new Exception('404');
	}
	require_once(__DIR__ . '/../private/initialize.php');
} catch(Exception $ex) {
	echo $ex->getMessage();
}