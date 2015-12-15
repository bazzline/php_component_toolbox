# Toolbox Component for PHP

This project aims to deliver an easy to use and free as in freedom php component full of toolbox things you need on your daily work with php.

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/php_component_toolbox
cd vendor/net_bazzline/php_component_toolbox
git clone https://github.com/bazzline/php_component_toolbox .
```

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_toolbox)

```
    composer require net_bazzline/php_component_toolbox:dev-master
```

# Available Sections

## [Array](https://github.com/bazzline/php_component_toolbox/tree/master/source/Net/Bazzline/Component/Toolbox/HashMap)

* [Combine](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/HashMap/Combine.php) - advanced implementation of [array_combine](http://php.net/manual/en/function.array-combine.php)
* [Merge](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/HashMap/Merge.php) - advanced implementation of [array_merge](http://php.net/manual/en/function.array-merge.php)

## [Collection](https://github.com/bazzline/php_component_toolbox/tree/master/source/Net/Bazzline/Component/Toolbox/Collection)

* [ChunkIterator](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Collection/Chunk/ChunkIterator.php) - easy up iteration by defining a minimum, a maxium and a step width and returning a [Chunk](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Collection/Chunk/Chunk.php)

## [Progress](https://github.com/bazzline/php_component_toolbox/tree/master/source/Net/Bazzline/Component/Toolbox/Progress)

* [EnumerableDeferred](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Process/EnumerableDeferred.php) - enables you to execute a prepare or a cleanup function after processing n entries
* [Experiment](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Process/Experiment.php) - enables you to try to execute a callback up to x times

## [Scalar](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Scalar)

* [Text](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Scalar/Text.php) - contains useful functions working with strings

## [Time](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Time)

* [Stopwatch](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Time/Stopwatch.php) - contains a stopwatch
* [Timestamp](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Time/Timestamp.php) - contains a timestamp object

# API

[API](http://www.bazzline.net/efef04b8bf3867f969285f1160d52ee8a719940e/index.html) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
        * add project overview (travis, scrutinizer, openhub etc.)
        * create examples for the sections
        * implement generator to update "Available Sections"
* [1.8.0](https://github.com/bazzline/php_component_toolbox/tree/1.8.0) - released at 15.12.2015
    * added [Merge](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/HashMap/Merge.php)
    * added [Text](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Scalar/Text.php)::hasTheLengthOf($string, $expectedLength), Text::isLongerThan($string, $expectedLength) and Text::isShorterThan($string, $expectedLength)
    * added [Text](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Scalar/Text.php)::hasTheLengthOf($string, $expectedLength), Text::isLongerThan($string, $expectedLength) and Text::isShorterThan($string, $expectedLength)
* [1.7.1](https://github.com/bazzline/php_component_toolbox/tree/1.7.1) - released at 11.12.2015
    * fixed broken link in release 1.6.0
    * updated dependency
* [1.7.0](https://github.com/bazzline/php_component_toolbox/tree/1.7.0) - released at 05.11.2015
    * added [Timestamp](https://github.com/bazzline/php_component_toolbox/blob/1.7.0/source/Net/Bazzline/Component/Toolbox/Time/Timestamp.php)
* [1.6.0](https://github.com/bazzline/php_component_toolbox/tree/1.6.0) - released at 02.11.2015
    * added [Stopwatch](https://github.com/bazzline/php_component_toolbox/blob/1.6.0/source/Net/Bazzline/Component/Toolbox/Time/Stopwatch.php)
    * update release notes
    * updated dependency to phpunit
* [1.5.0](https://github.com/bazzline/php_component_toolbox/tree/1.5.0) - released at 10.10.2015
    * added [Text](https://github.com/bazzline/php_component_toolbox/blob/1.5.0/source/Net/Bazzline/Component/Toolbox/Scalar/Text.php)
* [1.4.1](https://github.com/bazzline/php_component_toolbox/tree/1.4.1) - released at 17.09.2015
    * fixed validation issue and exception message spelling issue for the [Experiment](https://github.com/bazzline/php_component_toolbox/blob/1.4.1/source/Net/Bazzline/Component/Toolbox/Process/Experiment.php)
* [1.4.0](https://github.com/bazzline/php_component_toolbox/tree/1.4.0) - released at 10.09.2015
    * refactored api of the [Experiment](https://github.com/bazzline/php_component_toolbox/blob/1.4.0/source/Net/Bazzline/Component/Toolbox/Process/Experiment.php) heavily
* [1.3.0](https://github.com/bazzline/php_component_toolbox/tree/1.3.0) - released at 09.09.2015
    * added [Experiment](https://github.com/bazzline/php_component_toolbox/blob/1.3.0/source/Net/Bazzline/Component/Toolbox/Process/Experiment.php)
* [1.2.2](https://github.com/bazzline/php_component_toolbox/tree/1.2.2) - released at 23.08.2015
    * updated dependency
* [1.2.1](https://github.com/bazzline/php_component_toolbox/tree/1.2.1) - released at 03.08.2015
    * made [ChunkIterator](https://github.com/bazzline/php_component_toolbox/blob/1.2.1/source/Net/Bazzline/Component/Toolbox/Collection/Chunk/ChunkIterator.php) reusable by making constructor parameters optional and create public initialize method
* [1.2.0](https://github.com/bazzline/php_component_toolbox/tree/1.2.0) - released at 03.08.2015
    * added [ChunkIterator](https://github.com/bazzline/php_component_toolbox/blob/1.2.0/source/Net/Bazzline/Component/Toolbox/Collection/Chunk/ChunkIterator.php)
* [1.1.2](https://github.com/bazzline/php_component_toolbox/tree/1.1.2) - released at 03.08.2015
    * shifted parameters for EnumerableDeferred from (`$initializer, $finisher, $processor, $limit` to `$initializer, $processor, $finisher, $limit`)
* [1.1.1](https://github.com/bazzline/php_component_toolbox/tree/1.1.1) - released at 30.07.2015
    * updated dependency
* [1.1.0](https://github.com/bazzline/php_component_toolbox/tree/1.1.0) - released at 30.07.2015
    * added [EnumerableDeferred](https://github.com/bazzline/php_component_toolbox/blob/1.1.0/source/Net/Bazzline/Component/Toolbox/Process/EnumerableDeferred.php)
* [1.0.0](https://github.com/bazzline/php_component_toolbox/tree/1.0.0) - released at 26.06.2015
    * initial release 
