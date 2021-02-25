<?php
	define("CRUXOFT_ROOT", realpath(__DIR__ . "/../") . "/");

	require_once(CRUXOFT_ROOT . "vendor/autoload.php");

	use Cruxoft\Dump\Options;
	use function Cruxoft\dump;

	class Temp
	{
		public $one = 1;
		public $two = 2;
		public $three = 3;
	}

	function section(string $name): void
	{
		echo(PHP_EOL . $name . PHP_EOL);
	}

	section("Integer");
	dump(7, Options::NONE);

	section("Float");
	dump(3.14159265359);

	section("String");
	dump("Hello World");

	section("Booleans");
	dump(true);
	dump(false);

	section("Null");
	dump(null);

	section("Arrays");
	dump(array());
	dump(array("one", "two", "three"));
	dump(array(1, 2, 3));
	dump(array("one" => "first", "two" => "second", "three" => "third"));
	dump(array("one", false, 3));

	section("Object");
	dump((object)array("one" => "first", "two" => "second", "three" => "third"));

	section("Class");
	dump(new Temp());

	section("Resource");
	dump(curl_init());
?>
