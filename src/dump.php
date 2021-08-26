<?php
	namespace Cruxoft;

	use Cruxoft\Dump\Options;
	use Cruxoft\Dump\StructureItem;
	use Exception;

	function dump($object, $options = null): void
	{
		if ($options === null)
		{
			$default = getenv("CRUXOFT_DUMP_DEFAULT");

			$options = $default === false ? Options::DEFAULT : (int)$default;
		}

		if (($options & Options::INCLUDE_LOCATION) === Options::INCLUDE_LOCATION)
		{
			$debug = debug_backtrace();
			$path = $debug[0]['file'];

			if (($options & Options::RELATIVE_PATHS) === Options::RELATIVE_PATHS)
			{
				if (!defined("CRUXOFT_ROOT"))
				{
					throw new Exception("Constant 'CRUXOFT_ROOT' must be set to use relative paths");
				}

				$path = str_replace(realpath(CRUXOFT_ROOT) . "/", "", $path);
			}

			echo($path . "@" . $debug[0]['line'] . PHP_EOL);
		}

		echo(new StructureItem($object) . PHP_EOL);

		if (($options & Options::DIE_AFTER) === Options::DIE_AFTER)
		{
			die();
		}
	}
?>
