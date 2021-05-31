# Full Stop

I still like the idea but there is currently no use case to develop it anymore.

# Toolbox Component for PHP

This project aims to deliver an easy to use and free as in freedom php component full of toolbox things you need on your daily work with php.

The current change log can be found [here](CHANGELOG.md).

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

## [Array](https://github.com/bazzline/php_component_toolbox/tree/master/source/HashMap)

* [Combine](https://github.com/bazzline/php_component_toolbox/blob/master/source/HashMap/Combine.php) - advanced implementation of [array_combine](http://php.net/manual/en/function.array-combine.php)
* [Merge](https://github.com/bazzline/php_component_toolbox/blob/master/source/HashMap/Merge.php) - advanced implementation of [array_merge](http://php.net/manual/en/function.array-merge.php)

## [Collection](https://github.com/bazzline/php_component_toolbox/tree/master/source/Collection)

* [ChunkIterator](https://github.com/bazzline/php_component_toolbox/blob/master/source/Collection/Chunk/ChunkIterator.php) - easy up iteration by defining a minimum, a maxium and a step width and returning a [Chunk](https://github.com/bazzline/php_component_toolbox/blob/master/source/Collection/Chunk/Chunk.php)

## [Progress](https://github.com/bazzline/php_component_toolbox/tree/master/source/Progress)

* [EnumerableDeferred](https://github.com/bazzline/php_component_toolbox/blob/master/source/Process/EnumerableDeferred.php) - enables you to execute a prepare or a cleanup function after processing n entries
* [Experiment](https://github.com/bazzline/php_component_toolbox/blob/master/source/Process/Experiment.php) - enables you to try to execute a callback up to x times

## [Scalar](https://github.com/bazzline/php_component_toolbox/blob/master/source/Scalar)

* [Text](https://github.com/bazzline/php_component_toolbox/blob/master/source/Scalar/Text.php) - contains useful functions working with strings

## [Time](https://github.com/bazzline/php_component_toolbox/blob/master/source/Time)

* [Stopwatch](https://github.com/bazzline/php_component_toolbox/blob/master/source/Time/Stopwatch.php) - contains a stopwatch
* [Timestamp](https://github.com/bazzline/php_component_toolbox/blob/master/source/Time/Timestamp.php) - contains a timestamp object

# API

[API](http://www.bazzline.net/efef04b8bf3867f969285f1160d52ee8a719940e/index.html) is available at [bazzline.net](http://www.bazzline.net).

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if use it. Make a [donation](https://gratipay.com/~stevleibelt) if you love it :-].
