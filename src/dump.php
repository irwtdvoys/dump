<?php
	namespace Cruxoft;

	use Cruxoft\Dump\Options;
	use Cruxoft\Dump\StructureItem;

	function dump($object, $options = 0)
	{
		if (($options & Options::INCLUDE_LOCATION) === Options::INCLUDE_LOCATION)
		{
			$debug = debug_backtrace();
			echo($debug[0]['file'] . "@" . $debug[0]['line'] . PHP_EOL);
		}

		echo(new StructureItem($object) . "\n");
	}
?>
