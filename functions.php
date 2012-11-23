<?php

	require_once dir(__FILE__) . 'wp-logger.php';

	// simple message to console
	debug("A very simple message");

	// variable to console
	$x = 3;
	$y = 5;
	$z = $x/$y;
	debug($z);

	// warnign
	warn("A simple Warning");

	// info
	info("A simple Info message");

	// error
	error("A simple error messsage");

	// array
	$fruits = array("banana", "apple", "strawberry", "pineaple");
	debug($fruits);

	// object
	$book = (object) array(
		'title'        => "Harry Potter and the Prisoner of Azkaban",
		'author'       => "J. K. Rowling",
		'publisher'    => "Arthur A. Levine Books",
		'amazon_link'  => "http://www.amazon.com/dp/0439136",
	);
	debug($book);
