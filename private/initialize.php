<?php
// composer dump_autoload -o
require __DIR__ . '/../vendor/autoload.php';

ob_start();
require_once("db_credentials.php");
require_once("db_functions.php");
require_once('functions.php');

CONST PRIVATE_PATH = __DIR__;
define("PROJECT_PATH", dirname(__DIR__));
CONST PUBLIC_PATH = PROJECT_PATH . '\public';
CONST SHARED_PATH = PRIVATE_PATH . '\shared';

// doc root is htdocs
//$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
//$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);

// doc root is public folder
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, 0);

define("WWW_ROOT", $doc_root);

try {
	$db = db_connect();
} catch (\PDOException $e) {
	// TODO: Display an error page with some navigation when there is an error with the db connection, then exit the script.
	echo "<h1>Something went wrong with the database connection.</h1>";
	die("<p>Blame the developer!</p>");
} catch (Exception $e) {
	// Catching default exception. No need to show error page.
	echo "<h1>Something went wrong with the database connection.</h1>";
	die("<p>We're not sure what</p>");
}
