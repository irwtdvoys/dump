# Dump (0.2.2)

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
## Development

### Docker

If your local environment does not have an upto date version of PHP installed there is a docker environment is included in the codebase for quickly building a development/testing environment.

Your installed PHP version can be found with the following command:

```sh
$ php -v

PHP 7.2.1 (cli) (built: Jan  8 2018 23:39:24) ( NTS )
Copyright (c) 1997-2017 The PHP Group
Zend Engine v3.2.0, Copyright (c) 1998-2017 Zend Technologies
```

It uses the latest PHP7 FPM image and can be built and entered:

```sh
$ cd docker
$ docker-compose -p dump up
$ docker exec -it dump_php_1 bash

$ cd /code/
```

## Road Map

+ Ability to specify formatting parameters for output of dump function
+ Additional built-in conversions of structure data (json, xml, etc)
+ Coloured output
