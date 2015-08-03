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
            'equal maximum and minimum' => array(
                'maximum'   => 3,
                'minimum'   => 3,
                'step_size' => 1
            ),
            'minimum is greater than maximum' => array(
                'maximum'   => 3,
                'minimum'   => 4,
                'step_size' => 1
            )
        );
    }

    /**
     * @dataProvider provideInvalidInitialParameters
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage minimum must be less than the maximum
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
     * @expectedExceptionMessage step size must be less than the difference between the provided minimum and maximum
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
}
