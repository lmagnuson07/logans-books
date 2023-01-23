<?php

function url_for($script_path) {
	// add the leading '/' if not present
	if($script_path[0] != '/') {
		$script_path = "/" . $script_path;
	}
	return WWW_ROOT . $script_path;
}
// Use for url queries
function u($string="") {
	return urlencode($string);
}
// use for url path segments (/search?)
function raw_u($string="") {
	return rawurlencode($string);
}
function h($string="") {
	return htmlspecialchars($string);
}
function title_text($str) {
	$result = preg_replace("/[\-_.]/", " ", $str);
	return ucfirst($result);
}
function redirect_to($location) {
	header("Location: " . $location);
	exit;
}
function is_post_request() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}
function is_get_request() {
	return $_SERVER['REQUEST_METHOD'] == 'GET';
}