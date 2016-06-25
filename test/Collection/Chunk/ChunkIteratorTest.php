<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-08-03
 */
namespace Net\Bazzline\Component\Toolbox\Collection\Chunk;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class ChunkIteratorTest extends AbstractTestCase
{
    /**
     * @return array
     */
    public function provideInvalidInitialParameters()
    {
        return array(
            'equal totalMaximum and totalMinimum' => array(
                'totalMaximum'   => 3,
                'totalMinimum'   => 3,
                'step_size' => 1
            ),
            'totalMinimum is greater than totalMaximum' => array(
                'totalMaximum'   => 3,
                'totalMinimum'   => 4,
                'step_size' => 1
            )
        );
    }

    /**
     * @dataProvider provideInvalidInitialParameters
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage totalMinimum must be less than the totalMaximum
     * @param $maximum
     * @param $minimum
     * @param $stepSize
     */
    public function testInitiateWithInvalidParameters($maximum, $minimum, $stepSize)
    {
        $this->getNewCollectionChunkIterator($maximum, $minimum, $stepSize);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage step size must be less than the difference between the provided totalMinimum and totalMaximum
     */
    public function testInitiateWithInvalidStepSize()
    {
        $maximum    = 10;
        $minimum    = 1;
        $stepSize   = 10;

        $this->getNewCollectionChunkIterator($maximum, $minimum, $stepSize);
    }

    public function testWithMultipleSteps()
    {
        $maximum        = 17;
        $minimum        = 3;
        $stepSize       = 5;
        $numberOfChunks = 0;
        $chunkIterator  = $this->getNewCollectionChunkIterator($maximum, $minimum, $stepSize);

        foreach ($chunkIterator as $chunk) {
            $this->assertTrue(($maximum > $chunk->minimum()));
            $this->assertTrue(($minimum <= $chunk->minimum()));
            $this->assertTrue(($maximum >= $chunk->maximum()));
            ++$numberOfChunks;
        }

        $this->assertEquals(3, $numberOfChunks);
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
            $this->assertTrue(($maximum > $chunk->minimum()));
            $this->assertTrue(($minimum <= $chunk->minimum()));
            $this->assertTrue(($maximum >= $chunk->maximum()));
            ++$numberOfChunks;
        }

        $this->assertEquals(3, $numberOfChunks);
    }

    public function testThatNoChunkIsEverProcessedMoreThanOnce()
    {
        $chunkIterator      = $this->getNewCollectionChunkIterator();
        $expectedChunks     = array(
            0 => array(0, 9),
            1 => array(10, 19),
            2 => array(20, 29),
            3 => array(30, 30)
        );

        $chunkIterator->initialize(30, 0, 10);

        foreach ($chunkIterator as $index => $chunk) {
            $expectedMaximum    = $expectedChunks[$index][1];
            $expectedMinimum    = $expectedChunks[$index][0];

            $this->assertEquals($expectedMaximum, $chunk->maximum());
            $this->assertEquals($expectedMinimum, $chunk->minimum());
        }
    }
}
