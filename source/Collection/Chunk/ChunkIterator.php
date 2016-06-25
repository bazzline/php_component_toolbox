<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-08-03
 */
namespace Net\Bazzline\Component\Toolbox\Collection\Chunk;

use InvalidArgumentException;
use Iterator;

class ChunkIterator implements Iterator
{
    /** @var Chunk */
    private $currentChunk;

    /** @var int */
    private $currentStep;

    /** @var int */
    private $totalMaximum;

    /** @var int */
    private $totalMinimum;

    /** @var int */
    private $stepSize;

    /**
     * @param null|int $maximum
     * @param null|int $minimum
     * @param null|int $stepSize
     * @throws InvalidArgumentException
     */
    public function __construct($maximum = null, $minimum = null, $stepSize = null)
    {
        $allMandatoryArgumentsAreProvided = (
            (!is_null($maximum))
            && (!is_null($minimum))
            && (!is_null($stepSize))
        );

        if ($allMandatoryArgumentsAreProvided) {
            $this->initialize($maximum, $minimum, $stepSize);
        }
    }

    /**
     * @param int $maximum
     * @param int $minimum
     * @param int $stepSize
     * @throws InvalidArgumentException
     */
    public function initialize($maximum, $minimum, $stepSize)
    {
        if ($this->isGreaterThanOrEqual($minimum, $maximum)) {
            throw new InvalidArgumentException(
                'totalMinimum must be less than the totalMaximum'
            );
        }

        $minimumIncreasedByOneStepSize = $this->calculateNextMinimum($minimum, $stepSize);

        if ($this->isGreaterThanOrEqual($minimumIncreasedByOneStepSize, $maximum)) {
            throw new InvalidArgumentException(
                'step size must be less than the difference between the provided totalMinimum and totalMaximum'
            );
        }

        $this->setStepSize($stepSize);
        $this->setTotalMaximum($maximum);
        $this->setTotalMinimum($minimum);

        $this->rewind();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->currentStep;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return ($this->currentChunk instanceof Chunk);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return Chunk mixed Can return any type.
     */
    public function current()
    {
        return $this->currentChunk;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $currentChunk       = $this->currentChunk;
        $limit              = $this->totalMaximum;
        $nextChunkOrNull    = null;
        $stepSize           = $this->stepSize;

        $nextMaximum    = $this->calculateNextMaximum($currentChunk->maximum(), $stepSize);
        $nextMinimum    = $this->calculateNextMinimum($currentChunk->minimum(), $stepSize);

        if (!$this->isGreaterThanOrEqual($nextMinimum, $limit)) {
            if ($this->isGreaterThanOrEqual($nextMaximum, $limit)) {
                $nextMaximum = $limit;
            }

            $nextChunkOrNull = $this->createNewChunk($nextMaximum, $nextMinimum);
            $this->increaseCurrentStep();
        }

        $this->setCurrentChunkOrNull($nextChunkOrNull);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $initialMinimum = $this->totalMinimum;
        $stepSize       = $this->stepSize;
        $initialMaximum = $this->calculateInitialMaximum($initialMinimum, $stepSize);
        $initialChunk   = $this->createNewChunk($initialMaximum, $initialMinimum);

        $this->setCurrentChunkOrNull($initialChunk);
        $this->resetCurrentStep();
    }

    /**
     * @param int $minimum
     * @param int $stepSize
     * @return int
     */
    private function calculateInitialMaximum($minimum, $stepSize)
    {
        return ($this->calculateNextMaximum($minimum, $stepSize) - 1);
    }

    /**
     * @param int $currentMaximum
     * @param int $stepSize
     * @return int
     */
    private function calculateNextMaximum($currentMaximum, $stepSize)
    {
        return ($currentMaximum + $stepSize);
    }

    /**
     * @param int $currentMinimum
     * @param int $stepSize
     * @return int
     */
    private function calculateNextMinimum($currentMinimum, $stepSize)
    {
        return ($currentMinimum + $stepSize);
    }

    /**
     * @param int $maximum
     * @param int $minimum
     * @return Chunk
     */
    private function createNewChunk($maximum, $minimum)
    {
        return new Chunk($maximum, $minimum);
    }

    private function increaseCurrentStep()
    {
        ++$this->currentStep;
    }

    /**
     * @param int $numberOne
     * @param int $numberTwo
     * @return bool
     */
    private function isGreaterThanOrEqual($numberOne, $numberTwo)
    {
        return ($numberOne >= $numberTwo);
    }

    private function resetCurrentStep()
    {
        $this->currentStep = 0;
    }

    /**
     * @param null|Chunk $chunk
     */
    private function setCurrentChunkOrNull(Chunk $chunk = null)
    {
        $this->currentChunk = $chunk;
    }
    
    /**
     * @param int $stepSize
     */
    private function setStepSize($stepSize)
    {
        $this->stepSize = (int) $stepSize;
    }

    /**
     * @param int $maximum
     */
    private function setTotalMaximum($maximum)
    {
        $this->totalMaximum = (int) $maximum;
    }

    /**
     * @param int $minimum
     */
    private function setTotalMinimum($minimum)
    {
        $this->totalMinimum = (int) $minimum;
    }
}
