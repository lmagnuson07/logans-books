<?php
ob_start();
require_once("db_credentials.php");
require_once("db_functions.php");

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

$db = db_connect();

require_once('functions.php');