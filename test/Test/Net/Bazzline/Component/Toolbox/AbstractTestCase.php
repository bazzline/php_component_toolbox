<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-26
 */

namespace Test\Net\Bazzline\Component\Toolbox;

use InvalidArgumentException;
use Net\Bazzline\Component\Toolbox\Collection\Chunk\ChunkIterator;
use Net\Bazzline\Component\Toolbox\HashMap\Combine;
use Net\Bazzline\Component\Toolbox\Process\EnumerableDeferred;
use Net\Bazzline\Component\Toolbox\Process\Experiment;
use PHPUnit_Framework_TestCase;

/**
 * Class AbstractTestCase
 * @package Test\Net\Bazzline\Component\Toolbox
 */
abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @param int $maximum
     * @param int $minimum
     * @param int $stepSize
     * @return ChunkIterator
     * @throws InvalidArgumentException
     */
    protected function getNewCollectionChunkIterator($maximum = null, $minimum = null, $stepSize = null)
    {
        return new ChunkIterator($maximum, $minimum, $stepSize);
    }

    /**
     * @return Combine
     */
    protected function getHashMapCombine()
    {
        return new Combine();
    }

    /**
     * @param callable $initializer
     * @param callable $finisher
     * @param callable $processor
     * @param int $limit
     * @return EnumerableDeferred
     */
    protected function getNewEnumerableDeferredProcess($initializer, $finisher, $processor, $limit = 10)
    {
        return new EnumerableDeferred($initializer, $finisher, $processor, $limit);
    }

    /**
     * @return Experiment
     */
    protected function getNewExperimentProcess()
    {
        return new Experiment();
    }
}
