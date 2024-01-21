<?php
/**
 * The purpose of this file is to handle requests to the content server.
 * Since I have a rewrite rule for my application server that redirects to an index.php file, I can't access anything outside of the public folder (public assets for example).
 * To get around this, I created a content server using a VirtualHost where I output my min files.
 * However, when using the ES6 import, I needed to include the min.js for it to read the import in my content server.
 * This broke the phpstorm intellisense for imported functions however, which is very undesirable.
 * My workaround for this was to also add a rewrite rule for my content server that redirects to this index.php file.
 * From this file, I check the if the servers REQUEST_URI has the file extension or not.
 * If it doesn't, I add the extension, then check the content server to see if the file exists.
 * If it exists, the file is read normally.
 * Due to my CORS configuration, this also prevents direct access to my JS files in my content server, only allowing requests from the application server.
 * Images and css files can still be accessed directly from the content server url and only for GET requests.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since 		1.0
 * @version		1.0
 * @license 	http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 * @Created 	2023-07-23
 */

const APPLICATION_URL = "http://logans-books.local";

if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] === APPLICATION_URL) {
	// javascript file request.
	$requestedFile = "";
	if (!str_ends_with($_SERVER['REQUEST_URI'], ".min.js")) {
		if (str_ends_with($_SERVER['REQUEST_URI'], ".js")) {
			$requestedFile = str_replace(".js", ".min.js", $_SERVER['REQUEST_URI']);
		} else {
			$requestedFile = $_SERVER['REQUEST_URI'] . ".min.js";
		}
	} else {
		if (str_ends_with($_SERVER['REQUEST_URI'], ".min.js")) {
			$requestedFile = $_SERVER['REQUEST_URI'];
		}
	}
	$requestedFile = $_SERVER['DOCUMENT_ROOT'] . $requestedFile;
	if (file_exists($requestedFile)) {
		header("Content-Type: application/javascript");
		readfile($requestedFile);
		exit;
	}
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
	// Image file request.
	//		Images must have an extension
	$requestedFile = "";
	if (
		str_ends_with($_SERVER['REQUEST_URI'], ".png")
		|| str_ends_with($_SERVER['REQUEST_URI'], ".jpg")
		|| str_ends_with($_SERVER['REQUEST_URI'], ".jpeg")
		|| str_ends_with($_SERVER['REQUEST_URI'], ".svg")
		|| str_ends_with($_SERVER['REQUEST_URI'], ".webp")
	) {
		$requestedFile = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];
		$contentType = '';
		if (file_exists($requestedFile)) {
			$extension = pathinfo($requestedFile, PATHINFO_EXTENSION);
			switch ($extension) {
				case 'png':
					$contentType = 'image/png';
					break;
				case 'jpg':
				case 'jpeg':
					$contentType = 'image/jpeg';
					break;
				case 'svg':
					$contentType = 'image/svg+xml';
					break;
				case 'webp':
					$contentType = 'image/webp';
					break;
			}
			header('Content-Type: ' . $contentType);
			readfile($requestedFile);
			exit();
		}
	// Css file request
	} elseif (!str_ends_with($_SERVER['REQUEST_URI'], ".min.css")) {
		if (str_ends_with($_SERVER['REQUEST_URI'], ".css")) {
			$requestedFile = str_replace(".css", ".min.css", $_SERVER['REQUEST_URI']);
		} else {
			$requestedFile = $_SERVER['REQUEST_URI'] . ".min.css";
		}
	} else {
		if (str_ends_with($_SERVER['REQUEST_URI'], ".min.css")) {
			$requestedFile = $_SERVER['REQUEST_URI'];
		}
	}
	$requestedFile = $_SERVER['DOCUMENT_ROOT'] . $requestedFile;
	if (file_exists($requestedFile)) {
		header('Content-Type: text/css');
		readfile($requestedFile);
		exit;
	}
}

header('HTTP/1.1 403 Forbidden');
echo 'Forbidden';
exit;