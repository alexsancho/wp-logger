WP Logger
=========

wp_logger is a class designed to help on Wordpress theme/plugin development process. With this class you can output debug messages to browser console.

There are four available methods,

- debug
- info
- warn
- error

Usage example
-------------

Require the library on top of your theme functions.php or plugin file

`require_once dir(__FILE__) . '/wp-logger.php';`

Then you can do things like this on your code and watch the output on Firefox/Chrome console

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

Credits
-------

The idea was taken from [Codeforest article](http://www.codeforest.net/debugging-php-in-browsers-javascript-console)


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/alexsancho/wp-logger/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

