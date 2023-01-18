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
	<link rel="stylesheet" media="all" href="<?php echo url_for('/css/style.css'); ?>">
</head>
<body>
<header>
	<h1><?php echo $page_heading; ?> - [Admin Area]</h1>
	<nav>
		<ul>
			<li><a href="<?php echo url_for('/staff/book'); ?>">Books</a></li>
		</ul>
		<?php require_once('book_navigation.php'); ?>
	</nav>
</header>

<main>