<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-26
 */

namespace Test\Net\Bazzline\Component\Toolbox;

use InvalidArgumentException;
use Net\Bazzline\Component\Toolbox\Collection\Chunk\ChunkIterator;
use Net\Bazzline\Component\Toolbox\HashMap\Combine;
use Net\Bazzline\Component\Toolbox\HashMap\Merge;
use Net\Bazzline\Component\Toolbox\Process\EnumerableDeferred;
use Net\Bazzline\Component\Toolbox\Process\Experiment;
use Net\Bazzline\Component\Toolbox\Scalar\Text;
use Net\Bazzline\Component\Toolbox\Time\Stopwatch;
use Net\Bazzline\Component\Toolbox\Time\Timestamp;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTestCase
 * @package Test\Net\Bazzline\Component\Toolbox
 */
abstract class AbstractTestCase extends TestCase
{
    protected function getHashMapCombine(): Combine
    {
        return new Combine();
    }

    protected function getHashMapMerge(): Merge
    {
        return new Merge();
    }

    protected function getNewEnumerableDeferredProcess(callable $initializer, callable $finisher, callable $processor, int $limit = 10): EnumerableDeferred
    {
        return new EnumerableDeferred($initializer, $finisher, $processor, $limit);
    }

    protected function getNewExperimentProcess(): Experiment
    {
        return new Experiment();
    }

    protected function getNewText(): Text
    {
        return new Text();
    }

    protected function getNewStopwatchTime(): Stopwatch
    {
        return new Stopwatch();
    }

    protected function getNewTimestamp(): Timestamp
    {
        return new Timestamp();
    }
}
