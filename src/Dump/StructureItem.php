<?php
	namespace Cruxoft\Dump;

	class StructureItem
	{
		public $type;
		public $count;
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

		public function __construct($object = null, $level = 0)
		{
			$type = gettype($object);

			$this->level = $level;

			switch ($type)
			{
				case "boolean":
					$this->type = $type;
					$this->value = ($object === true) ? "true" : "false";
					break;
				case "integer":
					$this->type = $type;
					$this->value = $object;
					break;
				case "double":
					$this->type = "float";
					$this->value = $object;
					break;
				case "string":
					$this->type = $type;
					$this->count = strlen($object);
					$this->value = "\"" . (string)$object . "\"";
					break;
				case "array":
					$this->type = $type;
					$this->count = count($object);
					$this->children = array();

					foreach ($object as $key => $value)
					{
						$child = new StructureItem($value, ($level + 1));
						$child->isChild = true;
						$this->children[$key] = $child;
					}

					break;
				case "object":
					$class = get_class($object);
					$this->type = ($class === "stdClass") ? $type : "class";

					if ($class !== "stdClass")
					{
						$this->value = $class;
					}

					$this->children = array();

					foreach ($object as $key => $value)
					{
						$child = new StructureItem($value, ($level + 1));
						$child->isChild = true;
						$this->children[$key] = $child;
					}

					break;
				case "resource":
					$this->type = $type;
					$this->value = get_resource_type($object);

					$resources = get_resources($this->value);

					foreach ($resources as $key => $resource)
					{
						if ($object === $resource)
						{
							$this->count = (integer)$key;
							break;
						}
					}

					if ($this->value === "stream")
					{
						$meta = stream_get_meta_data($object);
						$this->value .= "-" . $meta['stream_type'];
					}

					break;
				case "NULL":
					$this->type = "null";
					break;
				default:
					$this->type = "unknown";
					break;
			}
		}
	}
?>
