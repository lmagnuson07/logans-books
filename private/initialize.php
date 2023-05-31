<?php
// composer dump-autoload -o

require __DIR__ . '/../vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

CONST PRIVATE_PATH = __DIR__;
define("PROJECT_PATH", dirname(__DIR__));
CONST PUBLIC_PATH = PROJECT_PATH . '\public';
CONST SHARED_PATH = PRIVATE_PATH . '\shared';

// Loads environment variables from .env to the $_ENV superglobal
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Setup for
$loader = new FilesystemLoader(PROJECT_PATH . '\views');
$twig = new Environment($loader, [
//	'cache' => PROJECT_PATH . '\storage\cache',
]);
ob_start();



// doc root is htdocs
//$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
//$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);

// doc root is public folder
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, 0);
//define("WWW_ROOT", $doc_root);
define("WWW_ROOT", $doc_root);

try {
	\App\Shared\DBObj::conn();
} catch (\PDOException $e) {
	// TODO: Display an error page with some navigation when there is an error with the db connection, then exit the script.
	echo "<h1>Something went wrong with the database connection.</h1>";
	echo "<p>" . $e->getMessage() . " - Error Code:" . (int)$e->getCode() . "</p>";
	die("<p>Blame the developer!</p>");
} catch (Exception $e) {
	// Catching default exception. No need to show error page.
	echo "<h1>Something went wrong with the database connection.</h1>";
	die("<p>We're not sure what</p>");
}

