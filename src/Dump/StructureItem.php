<?php
	namespace Cruxoft\Dump;

	use ReflectionClass;
    use UnitEnum;

    class StructureItem
	{
		public string $type;
		public int $count;
		public $value;
		public array $children;

		public int $level = 0;
		public bool $isChild = false;

		public function __toString(): string
		{
			$pattern = "\t";

			$spacer = str_repeat($pattern, $this->level);

			$output = "";

			if ($this->isChild === false)
			{
				$output .= $spacer;
			}

			$output .= $this->type;

			if (isset($this->count))
			{
				$output .= "(" . $this->count . ")";
			}

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

		public function __construct($object = null, int $level = 0, array $cache = [])
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
					$this->value = $object;
					break;
				case "array":
					$this->type = $type;
					$this->count = count($object);
					$this->children = array();

					foreach ($object as $key => $value)
					{
						$child = new StructureItem($value, ($level + 1), $cache);
						$child->isChild = true;
						$this->children[$key] = $child;
					}

					break;
				case "object":
					$id = spl_object_id($object);
					$class = get_class($object);
					$this->type = (($class === "stdClass") ? $type : "class") . "(#" . $id . ")";

					if ($class !== "stdClass")
					{
						$this->value = $class;
					}

					if (!in_array($id, $cache))
					{
						$cache[] = $id;

						$this->children = array();

                        if ($object instanceof UnitEnum)
                        {
                            $this->type = "enum";
                            $this->value .= "::" . $object->name;
                            unset($this->children);
                        }
                        elseif ($class !== "stdClass")
						{
							$reflection = new ReflectionClass($class);
							$properties = $reflection->getProperties();

							foreach ($properties as $property)
							{
								$details = array_filter([
									$property->isPublic() ? "public" : null,
									$property->isProtected() ? "protected" : null,
									$property->isPrivate() ? "private" : null,
									$property->isReadOnly() ? "readonly" : null,
									$property->isStatic() ? "static" : null,
								]);

								$child = new StructureItem($property->getValue($object), ($level + 1), $cache);
								$child->isChild = true;
								$this->children[$property->name . ":" . implode(":", $details)] = $child;
							}
						}
						else
						{
							foreach ($object as $key => $value)
							{
								$child = new StructureItem($value, ($level + 1), $cache);
								$child->isChild = true;
								$this->children[$key] = $child;
							}
						}
					}
					else
					{
						$this->value = trim($this->value . " (RECURSION)");
					}

					break;
				case "resource":
					$this->type = $type;
					$this->value = get_resource_type($object);
					$resources = get_resources($this->value);
					$this->count = (int)array_search($object, $resources, true);

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
