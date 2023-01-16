<?php
ob_start();

CONST PRIVATE_PATH = __DIR__;
define("PROJECT_PATH", dirname(__DIR__));
CONST PUBLIC_PATH = PROJECT_PATH . '\public';
CONST SHARED_PATH = PRIVATE_PATH . '\shared';

$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

require_once('functions.php');