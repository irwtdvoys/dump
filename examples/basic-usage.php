<?php
	define("CRUXOFT_ROOT", realpath(__DIR__ . "/../") . "/");

	use Cruxoft\Dump\Options;
	use function Cruxoft\dump;

	require_once(CRUXOFT_ROOT . "vendor/autoload.php");

	putenv("CRUXOFT_DUMP_DEFAULT=" . (Options::ALL & ~Options::DIE_AFTER));

	class Temp
	{
		public ?Temp $one = null;
		protected readonly int $two;
		static private int $three = 3;

		public function __construct()
		{
			$this->two = 2;
		}
	}

    enum TestEnum: int {
        case A = 1;
        case B = 2;
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

    section("Enum");
    dump(TestEnum::A);

	section("Arrays");
	dump([]);
	dump(["one", "two", "three"]);
	dump([1, 2, 3]);
	dump(["one" => "first", "two" => "second", "three" => "third"]);
	dump(["one", false, 3]);

	section("Object");
	dump((object)["one" => "first", "two" => "second", "three" => "third"]);

	section("Class");
	dump(new Temp());

	section("Resource");
	dump(fopen("php://memory", "rw"));

	section("Recursion");
	$tmp = new Temp();
	$tmp->one = $tmp;
	dump($tmp);
?>
