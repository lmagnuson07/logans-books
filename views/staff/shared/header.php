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
</head>
<body>
<header>
	<h1><?php echo $page_heading; ?> - [Admin Area]</h1>
	<nav>
		<ul>
			<li><a href="<?php echo App\Functions\HelperFunctions::url_for('staff/book'); ?>">Books</a></li>
		</ul>
		<ul>
			<li><a href="#">Author</a></li>
			<li><a href="#">Category</a></li>
			<li><a href="#">Edition</a></li>
			<li><a href="#">Genre</a></li>
			<li><a href="#">Publisher</a></li>
		</ul>
	</nav>
</header>

<main>