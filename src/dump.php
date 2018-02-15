<?php
	namespace Cruxoft;

	use Cruxoft\Dump\StructureItem;

	function dump($object)
	{
		echo(new StructureItem($object) . "\n");
	}
?>
