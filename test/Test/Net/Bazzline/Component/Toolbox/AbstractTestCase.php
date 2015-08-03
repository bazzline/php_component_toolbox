<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-26
 */

namespace Test\Net\Bazzline\Component\Toolbox;

use Net\Bazzline\Component\Toolbox\Collection\Chunk\ChunkIterator;
use Net\Bazzline\Component\Toolbox\HashMap\Combine;
use Net\Bazzline\Component\Toolbox\Process\EnumerableDeferred;
use PHPUnit_Framework_TestCase;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @param int $maximum
     * @param int $minimum
     * @param int $stepSize
     *
*@return ChunkIterator
     */
    protected function getNewCollectionChunkIterator($maximum, $minimum, $stepSize)
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
}
