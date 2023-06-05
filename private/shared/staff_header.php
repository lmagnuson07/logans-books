<?php
if(!isset($page_title)) { $page_title = 'Logan\'s Books'; }
if(!isset($page_heading)) { $page_heading = 'Logan\'s Books'; }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo $page_title; ?> - [Admin Area]</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holiday.css@0.9.8" />
	<link rel="stylesheet" media="all" href="<?php echo App\Functions\HelperFunctions::url_for('/css/staff-styles.css'); ?>">
	<!-- When using a CDN url you will have to manually update the version number -->
	<script src="https://unpkg.com/css-prefers-color-scheme@8.0.2/dist/browser-global.js"></script>
	<script src="<?php echo App\Functions\HelperFunctions::url_for('/js/main.min.js'); ?>"></script>
	<script>prefersColorSchemeInit()</script>
</head>
<body>
<header class="header">
	<h1><?php echo $page_heading; ?> - [Admin Area]</h1>
	<nav>
		<ul>
			<li><a href="<?php echo App\Functions\HelperFunctions::url_for('staff/book'); ?>">Books</a></li>
		</ul>
		<?php require('book_navigation.php'); ?>
	</nav>
</header>

<main>