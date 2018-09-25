# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Open]

### To Add

* add project overview (travis, scrutinizer, openhub etc.)
* create examples for the sections
* implement generator to update "Available Sections"

### To Change

## [Unreleased]

### Added

* added RealNumber
* added [this](CHANGELOG.md) changelog

### Changed

* fixed [issue/2](https://github.com/bazzline/php_component_toolbox/issues/2)
    * minimum and maximum can now be equal
    * step size can now be greater than the difference between provided minimum and maximum
* fixed [issue/3](https://github.com/bazzline/php_component_toolbox/issues/3)
    * each chunk item will be provided only once
* updated to phpunit 5.4
* added php 7.1 to travis
* added php 7.2 to travis

## [1.9.0](https://github.com/bazzline/php_component_toolbox/tree/1.9.0) - released at 06.03.2016

### Added

* added dedicated integration test for php 7.0

### Changed

* moved to psr-4 autoloading
* removed dedicated integration test for php 5.3.3

## [1.8.1](https://github.com/bazzline/php_component_toolbox/tree/1.8.0) - released at 12.01.2016

### Changed

* fixed dependency handling for phpunit 4.8.\*

## [1.8.0](https://github.com/bazzline/php_component_toolbox/tree/1.8.0) - released at 15.12.2015

### Added

* added [Merge](https://github.com/bazzline/php_component_toolbox/blob/master/source/HashMap/Merge.php)
* added [Text](https://github.com/bazzline/php_component_toolbox/blob/master/source/Scalar/Text.php)::hasTheLengthOf($string, $expectedLength), Text::isLongerThan($string, $expectedLength) and Text::isShorterThan($string, $expectedLength)
* added [Text](https://github.com/bazzline/php_component_toolbox/blob/master/source/Scalar/Text.php)::hasTheLengthOf($string, $expectedLength), Text::isLongerThan($string, $expectedLength) and Text::isShorterThan($string, $expectedLength)

## [1.7.1](https://github.com/bazzline/php_component_toolbox/tree/1.7.1) - released at 11.12.2015

### Changed

* fixed broken link in release 1.6.0
* updated dependency

## [1.7.0](https://github.com/bazzline/php_component_toolbox/tree/1.7.0) - released at 05.11.2015

### Added

* added [Timestamp](https://github.com/bazzline/php_component_toolbox/blob/1.7.0/source/Net/Bazzline/Component/Toolbox/Time/Timestamp.php)

## [1.6.0](https://github.com/bazzline/php_component_toolbox/tree/1.6.0) - released at 02.11.2015

### Added

* added [Stopwatch](https://github.com/bazzline/php_component_toolbox/blob/1.6.0/source/Net/Bazzline/Component/Toolbox/Time/Stopwatch.php)

### Changed

* update release notes
* updated dependency to phpunit

## [1.5.0](https://github.com/bazzline/php_component_toolbox/tree/1.5.0) - released at 10.10.2015

### Added

* added [Text](https://github.com/bazzline/php_component_toolbox/blob/1.5.0/source/Net/Bazzline/Component/Toolbox/Scalar/Text.php)

## [1.4.1](https://github.com/bazzline/php_component_toolbox/tree/1.4.1) - released at 17.09.2015

### Changed

* fixed validation issue and exception message spelling issue for the [Experiment](https://github.com/bazzline/php_component_toolbox/blob/1.4.1/source/Net/Bazzline/Component/Toolbox/Process/Experiment.php)

## [1.4.0](https://github.com/bazzline/php_component_toolbox/tree/1.4.0) - released at 10.09.2015

### Changed

* refactored api of the [Experiment](https://github.com/bazzline/php_component_toolbox/blob/1.4.0/source/Net/Bazzline/Component/Toolbox/Process/Experiment.php) heavily

## [1.3.0](https://github.com/bazzline/php_component_toolbox/tree/1.3.0) - released at 09.09.2015

### Added

* added [Experiment](https://github.com/bazzline/php_component_toolbox/blob/1.3.0/source/Net/Bazzline/Component/Toolbox/Process/Experiment.php)

## [1.2.2](https://github.com/bazzline/php_component_toolbox/tree/1.2.2) - released at 23.08.2015

### Changed

* updated dependency

## [1.2.1](https://github.com/bazzline/php_component_toolbox/tree/1.2.1) - released at 03.08.2015

### Changed

* made [ChunkIterator](https://github.com/bazzline/php_component_toolbox/blob/1.2.1/source/Net/Bazzline/Component/Toolbox/Collection/Chunk/ChunkIterator.php) reusable by making constructor parameters optional and create public initialize method

## [1.2.0](https://github.com/bazzline/php_component_toolbox/tree/1.2.0) - released at 03.08.2015

### Added

* added [ChunkIterator](https://github.com/bazzline/php_component_toolbox/blob/1.2.0/source/Net/Bazzline/Component/Toolbox/Collection/Chunk/ChunkIterator.php)

## [1.1.2](https://github.com/bazzline/php_component_toolbox/tree/1.1.2) - released at 03.08.2015

### Changed

* shifted parameters for EnumerableDeferred from (`$initializer, $finisher, $processor, $limit` to `$initializer, $processor, $finisher, $limit`)

## [1.1.1](https://github.com/bazzline/php_component_toolbox/tree/1.1.1) - released at 30.07.2015

### Changed

* updated dependency 

## [1.1.0](https://github.com/bazzline/php_component_toolbox/tree/1.1.0) - released at 30.07.2015

### Added

* added [EnumerableDeferred](https://github.com/bazzline/php_component_toolbox/blob/1.1.0/source/Net/Bazzline/Component/Toolbox/Process/EnumerableDeferred.php)

## [1.0.0](https://github.com/bazzline/php_component_toolbox/tree/1.0.0) - released at 26.06.2015

### Added

* initial release 
