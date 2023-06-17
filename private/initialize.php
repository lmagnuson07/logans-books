<?php
// composer dump-autoload -o
require __DIR__ . '/../vendor/autoload.php';
use App\App;
use App\Config\Config;
use App\Router;

ob_start();
session_start();

App::setDependencies();
App::initConsts();

$app = new App(
	[
		'uri' => $_SERVER['REQUEST_URI'],
		'method' => $_SERVER['REQUEST_METHOD']
	],
	new Config($_ENV)
);

$router = new Router();
$app->mainRouter($router);

if (App::$hasStaticView) {
	echo App::$staticView;
} else {
	$app->run();
}

if ($app->hasView) {
	echo $app->view;
}

App::disconn();