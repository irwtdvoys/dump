<?php
	namespace Cruxoft;

	class Dump
	{
		public $type;
		public $value;
		public $children;

		public $level = 0;
		public $isChild = false;

		public function __toString()
		{
			$pattern = "    ";

			$spacer = str_repeat($pattern, $this->level);

			$output = "";

			if ($this->isChild === false)
			{
				$output .= $spacer;
			}

			$output .= $this->type;

			if (isset($this->value) || isset($this->children))
			{
				$output .= ": ";
			}

			if (isset($this->value))
			{
				$output .= $this->value . " ";
			}

			if (isset($this->children))
			{
				$output .= "\n" . $spacer . "(\n";


				foreach ($this->children as $key => $item)
				{
					if (!is_numeric($key))
					{
						$key = "'" . $key . "'";
					}
					$output .= $spacer . $pattern . "[" . $key . "] " . $item . "\n";
				}



				$output .= $spacer . ")";
			}

			return $output;
		}

		public static function structure($object, $level = 0)
		{
			$type = gettype($object);

			$item = new Dump();
			$item->level = $level;

			switch ($type)
			{
				case "boolean":
					$item->type = $type;
					$item->value = ($object === true) ? "true" : "false";
					break;
				case "integer":
					$item->type = $type;
					$item->value = $object;
					break;
				case "double":
					$item->type = "float";
					$item->value = $object;
					break;
				case "string":
					$item->type = $type . "(" . strlen($object) . ")";
					$item->value = "\"" . (string)$object . "\"";
					break;
				case "array":
					$item->type = $type . "(" . count($object) . ")";
					$item->children = array();

					foreach ($object as $key => $value)
					{
						$child = self::structure($value, ($level + 1));
						$child->isChild = true;
						$item->children[$key] = $child;
					}

					break;
				case "object":
					$class = get_class($object);
					$item->type = ($class === "stdClass") ? $type : "class";

					if ($class !== "stdClass")
					{
						$item->value = $class;
					}

					$item->children = array();

					foreach ($object as $key => $value)
					{
						$child = self::structure($value, ($level + 1));
						$child->isChild = true;
						$item->children[$key] = $child;
					}

					break;
				case "resource":
					$item->type = $type;
					$item->value = get_resource_type($object);

					$resources = get_resources($item->value);

					foreach ($resources as $key => $resource)
					{
						if ($object === $resource)
						{
							$item->type .= "(" . $key . ")";
							break;
						}
					}

					if ($item->value === "stream")
					{
						$meta = stream_get_meta_data($object);
						$item->value .= "-" . $meta['stream_type'];
					}

					break;
				case "NULL":
					$item->type = "null";
					break;
				default:
					$item->type = "unknown";
					break;
			}

			return $item;
		}
	}
?>
