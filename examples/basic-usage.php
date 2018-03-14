<?php

	define("ROOT_SERVER", __DIR__ . "/../");

	require_once(ROOT_SERVER . "vendor/autoload.php");

	use function Cruxoft\dump;

	class Temp
	{
		public $one = 1;
		public $two = 2;
		public $three = 3;
	}

	echo("\nInteger\n");
	dump(7);

	echo("\nFloat\n");
	dump(3.14159265359);

	echo("\nString\n");
	dump("Hello World");

	echo("\nBooleans\n");
	dump(true);
	dump(false);

	echo("\nNull\n");
	dump(null);

	echo("\nArrays\n");
	dump(array());
	dump(array("one", "two", "three"));
	dump(array(1, 2, 3));
	dump(array("one" => "first", "two" => "second", "three" => "third"));
	dump(array("one", false, 3));

	echo("\nObject\n");
	dump((object)array("one" => "first", "two" => "second", "three" => "third"));

	echo("\nClass\n");
	dump(new Temp());

	echo("\nResource\n");
	dump(curl_init());
?>
