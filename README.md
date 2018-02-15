# Dump

## What is it?

An alternative to `var_dump` or `print_r` for generating structure information about variables to then be output.  

## Installation

Can be installed using composer by running the following:

```sh
$ composer require cruxoft/dump
```

## Usage

Some simple usage examples of `Dump` would be as follows:

```php
use function Cruxoft\dump;

dump(array("one", "two", 3));
dump(true);
dump("Hello World");
```

Which would output:

```
array(3):
(
    [0] string(3): "one"
    [1] string(3): "two"
    [2] integer: 3
)
boolean: true
string(11): "Hello World"
```
