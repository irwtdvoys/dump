# Dump (0.3.1)

## What is it?

An alternative to `var_dump` or `print_r` for generating structure information about variables to then be output.

## Installation

Can be installed using composer by running the following:

```sh
$ composer require cruxoft/dump
```

## Usage

For details on full basic usage and more complex examples see the `examples/` folder.

### Output Function

Some simple output based usage examples of the built in `dump()` function would be as follows:

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

The `dump` method can take an optional `options` parameter as a bitwise value of the required options. Available options are:

+ **INCLUDE_LOCATION**: Gives the file and line number of the `dump` call.
+ **DIE_AFTER**: Calls `die()` after the `dump` method is completed.

```php
use Cruxoft\Dump\Options;
use function Cruxoft\dump;

dump("Hello World", Options::INCLUDE_LOCATION);
```

```
examples/file.php@4
string(11): "Hello World"
```

## Development

### Docker

If your local environment does not have an upto date version of PHP installed there is a docker environment is included in the codebase for quickly building a development/testing environment.

Your installed PHP version can be found with the following command:

```sh
$ php -v

PHP 8.0.7 (cli) (built: Jun 23 2021 12:34:03) ( NTS )
Copyright (c) The PHP Group
Zend Engine v4.0.7, Copyright (c) Zend Technologies
```

It uses the latest PHP8 FPM image with composer added and can be built and entered:

```sh
$ cd docker
$ docker-compose -p dump up -d
$ docker exec -it dump_php_1 bash
```

The container can be torn down with:

```sh
$ docker-compose stop
```

## Road Map

+ Ability to specify formatting parameters for output of dump function
+ Additional built-in conversions of structure data (json, xml, etc)
+ Coloured output
+ Handling recursion
+ Options
