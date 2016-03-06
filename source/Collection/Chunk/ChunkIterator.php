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
    private $maximum;

    /** @var int */
    private $minimum;

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
        if ((!is_null($maximum))
            && (!is_null($minimum))
            && (!is_null($stepSize))) {
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
        $this->maximum  = (int) $maximum;
        $this->minimum  = (int) $minimum;
        $this->stepSize = (int) $stepSize;

        if ($this->isGreaterThanOrEqual($this->minimum, $this->maximum)) {
            throw new InvalidArgumentException(
                'minimum must be less than the maximum'
            );
        }

        $minimumIncreasedByOneStepSize = $this->minimum + $this->stepSize;

        if ($this->isGreaterThanOrEqual($minimumIncreasedByOneStepSize, $this->maximum)) {
            throw new InvalidArgumentException(
                'step size must be less than the difference between the provided minimum and maximum'
            );
        }

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
        $chunk      = null;
        $current    = $this->currentChunk;
        $limit      = $this->maximum;
        $stepSize   = $this->stepSize;

        $maximum    = ($current->maximum() + $stepSize);
        $minimum    = $this->calculateNextMinimum($current->minimum(), $stepSize);

        if (!$this->isGreaterThanOrEqual($minimum, $limit)) {
            if ($this->isGreaterThanOrEqual($maximum, $limit)) {
                $maximum = $limit;
            }

            $chunk = $this->createNewChunk($maximum, $minimum);
            ++$this->currentStep;
        }

        $this->currentChunk = $chunk;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $minimum    = $this->minimum;
        $maximum    = $this->calculateNextMinimum($minimum, $this->stepSize);

        $this->currentChunk = $this->createNewChunk($maximum, $minimum);
        $this->currentStep  = 0;
    }

    /**
     * @param int $minimum
     * @param int $stepSize
     * @return int
     */
    private function calculateNextMinimum($minimum, $stepSize)
    {
        return ($minimum + $stepSize);
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

    /**
     * @param int $numberOne
     * @param int $numberTwo
     * @return bool
     */
    private function isGreaterThanOrEqual($numberOne, $numberTwo)
    {
        return ($numberOne >= $numberTwo);
    }
}
