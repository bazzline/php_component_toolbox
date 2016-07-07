<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-08-03
 */
namespace Net\Bazzline\Component\Toolbox\Collection\Chunk;

use InvalidArgumentException;
use Iterator;
use Net\Bazzline\Component\Toolbox\Scalar\RealNumber;

class ChunkIterator implements Iterator
{
    /** @var Chunk */
    private $currentChunk;

    /** @var int */
    private $currentStep;

    /** @var Chunk */
    private $nextChunk;

    /** @var RealNumber */
    private $stepSize;

    /** @var @var boolean */
    private $stopOnNextIteration;

    /** @var RealNumber */
    private $totalMaximum;

    /** @var RealNumber */
    private $totalMinimum;

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
        //validates input
        //  min >= min -> exception
        //sets initial minimum, initial maximum, total maximum and step size
        $maximum    = new RealNumber($maximum);
        $minimum    = new RealNumber($minimum);
        $stepSize   = new RealNumber($stepSize);

        if ($maximum->isLessThan($minimum)) {
            throw new InvalidArgumentException(
                'provided minimum must be less than or equal the provided maximum'
            );
        }

        //@see
        //  https://github.com/bhearsum/chunkify/blob/master/chunkify/__init__.py
        //  https://github.com/darrell-pittman/iterator-chunker/blob/master/index.js
        //
        $minimumIncreasedByOneStepSize          = $this->calculateNextMinimum($minimum, $stepSize);
        $minimumPlusStepSizeIsAboveTheMaximum   = $minimumIncreasedByOneStepSize->isGreaterThan($maximum);

        if ($minimumPlusStepSizeIsAboveTheMaximum) {
            $stepSize = $maximum->minus($minimum);
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
        //calculates next chunk based on current chunk, step size and total maximum
        //sets next chunk as current chunk (or null or we move a "chunk->maxinum > $totalMaxmimum" logic into the valid method
        $currentChunk       = $this->currentChunk;
        $limit              = $this->totalMaximum;
        $nextChunkOrNull    = null;
        $stepSize           = $this->stepSize;

echo PHP_EOL . 'current minimum: ' . $currentChunk->minimum();
echo PHP_EOL . 'current maximum: ' . $currentChunk->maximum();
        $nextMaximum    = $this->calculateNextMaximum($currentChunk->maximum(), $stepSize);
        $nextMinimum    = $this->calculateNextMinimum($currentChunk->minimum(), $stepSize);

echo PHP_EOL . 'next minimum: ' . $nextMinimum;
echo PHP_EOL . 'next maximum: ' . $nextMaximum;
echo PHP_EOL . 'limit: ' . $limit;
        $nextMinimumIsEqualOrBelowTheLimit = $nextMinimum->isLessThanOrEqual($limit);

        if ($nextMinimumIsEqualOrBelowTheLimit) {
            $nextMaximumIsAboveTheLimit = $nextMinimum->isGreaterThan($limit);

            if ($nextMaximumIsAboveTheLimit) {
                $nextMaximum = $limit;
            }

            $nextChunkOrNull = $this->createNewChunk($nextMaximum, $nextMinimum);
            $this->increaseCurrentStep();
        } else {
            if ($this->doNotStopOnThisIterator()) {
                $nextMaximum = $limit;
                $nextMinimum = $limit;
                $nextChunkOrNull = $this->createNewChunk($nextMaximum, $nextMinimum);
                $this->increaseCurrentStep();
                $this->stopOnNextIteration();
echo PHP_EOL . '    next minimum: ' . $nextMinimum;
echo PHP_EOL . '    limit: ' . $limit;
            }
        }
echo PHP_EOL . 'is chunk ' . (is_null($nextChunkOrNull) ? 'no' : 'yes');
echo PHP_EOL;

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
        //resets current step
        //creates current chunk based on initial minimum, step size and total maximum
        $initialMinimum = $this->totalMinimum;
        $stepSize       = $this->stepSize;
        $initialMaximum = $this->calculateInitialMaximum($initialMinimum, $stepSize);

        if ($initialMaximum->isLessThan($initialMinimum)) {
            $initialMaximum = $initialMinimum;
            $nextChunk      = null;
        } else {
            $nextMinimum    = $this->calculateNextMinimum($initialMinimum, $stepSize);
            $nextMaximum    = $this->calculateNextMaximum($initialMaximum, $stepSize);
            $nextChunk      = $this->createNewChunk($nextMaximum, $nextMinimum);
        }

        $initialChunk   = $this->createNewChunk($initialMaximum, $initialMinimum);

        $this->setNextChunkOrNull($nextChunk);
        $this->doNotStopOnNextIteration();
        $this->resetCurrentStep();
        $this->setCurrentChunkOrNull($initialChunk);
    }

    /**
     * @param RealNumber $minimum
     * @param RealNumber $stepSize
     * @return RealNumber
     */
    private function calculateInitialMaximum(RealNumber $minimum, RealNumber $stepSize)
    {
        return ($this->calculateNextMaximum($minimum, $stepSize)->minus(new RealNumber(1)));
    }

    /**
     * @param RealNumber $currentMaximum
     * @param RealNumber $stepSize
     * @return RealNumber
     */
    private function calculateNextMaximum(RealNumber $currentMaximum, RealNumber $stepSize)
    {
        return ($currentMaximum->plus($stepSize));
    }

    /**
     * @param RealNumber $currentMinimum
     * @param RealNumber $stepSize
     * @return RealNumber
     */
    private function calculateNextMinimum(RealNumber $currentMinimum, RealNumber $stepSize)
    {
        return ($currentMinimum->plus($stepSize));
    }

    /**
     * @param RealNumber $maximum
     * @param RealNumber $minimum
     * @return Chunk
     */
    private function createNewChunk(RealNumber $maximum, RealNumber $minimum)
    {
        return new Chunk((string) $maximum, (string) $minimum);
    }

    private function increaseCurrentStep()
    {
        ++$this->currentStep;
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
     * @param Chunk|null $chunk
     */
    private function setNextChunkOrNull(Chunk $chunk = null)
    {
        $this->nextChunk = $chunk;
    }
    
    /**
     * @param RealNumber $stepSize
     */
    private function setStepSize(RealNumber $stepSize)
    {
        $this->stepSize = $stepSize;
    }

    /**
     * @param RealNumber $maximum
     */
    private function setTotalMaximum(RealNumber $maximum)
    {
        $this->totalMaximum = $maximum;
    }

    /**
     * @param RealNumber $minimum
     */
    private function setTotalMinimum(RealNumber $minimum)
    {
        $this->totalMinimum = $minimum;
    }

    /**
     * @return bool
     * @todo find a better name
     */
    private function doNotStopOnThisIterator()
    {
        return ($this->stopOnNextIteration !== true);
    }

    private function stopOnNextIteration()
    {
        $this->stopOnNextIteration = true;
    }

    private function doNotStopOnNextIteration()
    {
        $this->stopOnNextIteration = false;
    }
}
