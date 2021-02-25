<?php
	namespace Cruxoft;

	use Cruxoft\Dump\Options;
	use Cruxoft\Dump\StructureItem;

	function dump($object, $options = null): void
	{
		if ($options === null)
		{
			$default = getenv("CRUXOFT_DUMP_DEFAULT");

			$options = $default === false ? 0 : (int)$default;
		}

		if (($options & Options::INCLUDE_LOCATION) === Options::INCLUDE_LOCATION)
		{
			$debug = debug_backtrace();
			$path = $debug[0]['file'];

			echo($path . "@" . $debug[0]['line'] . PHP_EOL);
		}

		echo(new StructureItem($object) . PHP_EOL);

		if (($options & Options::DIE_AFTER) === Options::DIE_AFTER)
		{
			die();
		}
	}
?>
