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

## [Collection](https://github.com/bazzline/php_component_toolbox/tree/master/source/Net/Bazzline/Component/Toolbox/Collection)

* [ChunkIterator](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Collection/Chunk/ChunkIterator.php) - easy up iteration by defining a minimum, a maxium and a step width and returning a [Chunk](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Collection/Chunk/Chunk.php)

## [Progress](https://github.com/bazzline/php_component_toolbox/tree/master/source/Net/Bazzline/Component/Toolbox/Progress)

* [EnumerableDeferred](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Process/EnumerableDeferred.php) - enables you to execute a prepare or a cleanup function after processing n entries

# API

[API](http://www.bazzline.net/efef04b8bf3867f969285f1160d52ee8a719940e/index.html) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
        * add project overview (travis, scrutinizer, openhub etc.)
        * create examples for the sections
        * implement generator to update "Available Sections"
* [1.2.0](https://github.com/bazzline/php_component_toolbox/tree/1.2.0) - released at 03.08.2015
    * added [ChunkIterator](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Collection/Chunk/ChunkIterator.php)
* [1.1.2](https://github.com/bazzline/php_component_toolbox/tree/1.1.2) - released at 03.08.2015
    * shifted parameters for EnumerableDeferred from (`$initializer, $finisher, $processor, $limit` to `$initializer, $processor, $finisher, $limit`)
* [1.1.1](https://github.com/bazzline/php_component_toolbox/tree/1.1.1) - released at 30.07.2015
    * updated dependency
* [1.1.0](https://github.com/bazzline/php_component_toolbox/tree/1.1.0) - released at 30.07.2015
    * added [EnumerableDeferred](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Process/EnumerableDeferred.php)
* [1.0.0](https://github.com/bazzline/php_component_toolbox/tree/1.0.0) - released at 26.06.2015
    * initial release 
