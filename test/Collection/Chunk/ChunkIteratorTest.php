<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-08-03
 */
namespace Net\Bazzline\Component\Toolbox\Collection\Chunk;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class ChunkIteratorTest extends AbstractTestCase
{
    public function testFoo()
    {
        $this->testThatNoChunkIsEverProcessedMoreThanOnce();
    }
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage provided minimum must be less than or equal the provided maximum
     */
    public function testInitializeWithInvalidParameters()
    {
        $maximum    = 3;
        $minimum    = 4;
        $stepSize   = 1;

        $this->getNewCollectionChunkIterator($maximum, $minimum, $stepSize);
    }

    public function testWithJustOneItemInAChunk()
    {
        $chunkIterator          = $this->getNewCollectionChunkIterator();
        $expectedNumberOfChunks = 1;
        $numberOfChunks         = 0;

        $chunkIterator->initialize(0, 0, 1);

        foreach ($chunkIterator as $chunk) {
            self::assertEquals(0, $chunk->maximum());
            self::assertEquals(0, $chunk->minimum());

            ++$numberOfChunks;
        }

        self::assertEquals($expectedNumberOfChunks, $numberOfChunks);
    }

    public function testInitializeWithEqualMinimumAndMaximum()
    {
        $maximum    = 4;
        $minimum    = 4;
        $stepSize   = 4;

        $chunkIterator = $this->getNewCollectionChunkIterator();
        $chunkIterator->initialize($maximum, $minimum, $stepSize);

        $currentChunk = $chunkIterator->current();

        self::assertEquals($maximum, $currentChunk->maximum());
        self::assertEquals($minimum, $currentChunk->minimum());
    }

    public function testWithMultipleSteps()
    {
        $maximum        = 17;
        $minimum        = 3;
        $stepSize       = 5;
        $numberOfChunks = 0;
        $chunkIterator  = $this->getNewCollectionChunkIterator($maximum, $minimum, $stepSize);

        foreach ($chunkIterator as $chunk) {
            self::assertTrue(($maximum > $chunk->minimum()));
            self::assertTrue(($minimum <= $chunk->minimum()));
            self::assertTrue(($maximum >= $chunk->maximum()));
            ++$numberOfChunks;
        }

        self::assertEquals(3, $numberOfChunks);
    }

    public function testWithMultipleStepsByCallingInitialize()
    {
        $maximum        = 17;
        $minimum        = 3;
        $stepSize       = 5;
        $numberOfChunks = 0;
        $chunkIterator  = $this->getNewCollectionChunkIterator();

        $chunkIterator->initialize($maximum, $minimum, $stepSize);

        foreach ($chunkIterator as $chunk) {
            self::assertTrue(($maximum > $chunk->minimum()));
            self::assertTrue(($minimum <= $chunk->minimum()));
            self::assertTrue(($maximum >= $chunk->maximum()));
            ++$numberOfChunks;
        }

        self::assertEquals(3, $numberOfChunks);
    }

    public function testWithJustOneItem()
    {
        $chunkIterator = $this->getNewCollectionChunkIterator();
        $chunkIterator->initialize(0, 0, 1);
    }

    public function testThatNoChunkIsEverProcessedMoreThanOnce()
    {
        $chunkIterator          = $this->getNewCollectionChunkIterator();
        $expectedChunks         = [
            0 => [0, 9],
            1 => [10, 19],
            2 => [20, 29],
            3 => [30, 30]
        ];
        $expectedNumberOfChunks = count($expectedChunks);
        $numberOfChunks         = 0;

        $chunkIterator->initialize(30, 0, 10);

        foreach ($chunkIterator as $index => $chunk) {
            $expectedMaximum    = $expectedChunks[$index][1];
            $expectedMinimum    = $expectedChunks[$index][0];

            self::assertEquals($expectedMaximum, $chunk->maximum());
            self::assertEquals($expectedMinimum, $chunk->minimum());

            ++$numberOfChunks;
        }

        self::assertEquals($expectedNumberOfChunks, $numberOfChunks);
    }
}
