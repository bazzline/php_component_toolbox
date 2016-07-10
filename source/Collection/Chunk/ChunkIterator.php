<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-08-03
 */
namespace Net\Bazzline\Component\Toolbox\Collection\Chunk;

use InvalidArgumentException;
use Iterator;
use Net\Bazzline\Component\Toolbox\Scalar\RealNumber;

/**
 * Class ChunkIterator
 *
 * @package Net\Bazzline\Component\Toolbox\Collection\Chunk
 * @see
 *  https://github.com/bhearsum/chunkify/blob/master/chunkify/__init__.py
 *  https://github.com/darrell-pittman/iterator-chunker/blob/master/index.js
 */
class ChunkIterator implements Iterator
{
    /** @var Chunk */
    private $currentChunk;

    /** @var int */
    private $currentStep;

    /** @var RealNumber */
    private $initialMinimum;

    /** @var Chunk */
    private $nextChunk;

    /** @var RealNumber */
    private $stepSize;

    /** @var @var boolean */
    private $stopOnNextIteration;

    /** @var RealNumber */
    private $totalMaximum;

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
     * @param int $totalMaximum
     * @param int $initialMinimum
     * @param int $stepSize
     * @throws InvalidArgumentException
     */
    public function initialize($totalMaximum, $initialMinimum, $stepSize)
    {
        //begin of input validation
        $initialMinimum     = $this->createNewRealNumber($initialMinimum);
        $stepSize           = $this->createNewRealNumber($stepSize);
        $totalMaximum       = $this->createNewRealNumber($totalMaximum);

        if ($totalMaximum->isLessThan($initialMinimum)) {
            throw new InvalidArgumentException(
                'provided minimum must be less than or equal the provided maximum'
            );
        }
        //end of input validation

        //begin of input value adaptation
        $nextMaximum                            = $this->calculateNextMaximum($initialMinimum, $stepSize);
        $nextMaximumIsGreaterThanTotalMaximum   = $nextMaximum->isGreaterThan($totalMaximum);

        if ($nextMaximumIsGreaterThanTotalMaximum) {
            //looks like it will be only one chunk - the highlander chunk! :D
            $stepSize = $totalMaximum->minus($initialMinimum);
        }
        //end of input value adaptation

        $this->setStepSize($stepSize);
        $this->setTotalMaximum($totalMaximum);
        $this->setInitialMinimum($initialMinimum);

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
        //begin of dependencies
        $currentChunk       = $this->currentChunk;
        $stepSize           = $this->stepSize;
        $totalMaximum       = $this->totalMaximum;
        //end of dependencies

        //begin of dynamic dependencies
        $currentMinimum = $this->createNewRealNumber($currentChunk->minimum());
        $currentMaximum = $this->createNewRealNumber($currentChunk->maximum());
        $nextMinimum    = $this->calculateNextMinimum($currentMaximum);
        $nextMaximum    = $this->calculateNextMaximum($currentMaximum, $stepSize);
        echo PHP_EOL . 'current minimum: ' . $currentMinimum;
        echo PHP_EOL . 'current maxinum: ' . $currentMaximum;
        echo PHP_EOL . 'next minimum: ' . $nextMinimum;
        echo PHP_EOL . 'next maximum: ' . $nextMaximum;
        //end of dynamic dependencies

        //begin of business logic
        if ($nextMinimum->isGreaterThan($totalMaximum)) {
            $nextChunk = null;
        } else {
            if ($nextMaximum->isGreaterThan($totalMaximum)) {
                $nextMaximum = $totalMaximum;
            }

            $nextChunk = $this->createNewChunk($nextMaximum, $nextMinimum);
        }
        //end of business logic

        $this->increaseCurrentStep();
        $this->setCurrentChunkOrNull($nextChunk);

        /*
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
        */
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        //begin of dependencies
        $initialMinimum = $this->initialMinimum;
        $stepSize       = $this->stepSize;
        //end of dependencies

        //begin of dynamic dependencies
        $nextMaximum    = $this->calculateInitialMaximum($initialMinimum, $stepSize);
        $currentChunk   = $this->createNewChunk($nextMaximum, $initialMinimum);
        //end of dynamic dependencies

        $this->initialCurrentStepSize();
        $this->setCurrentChunkOrNull($currentChunk);

        /** @todo remove
        //resets current step
        //creates current chunk based on initial minimum, step size and total maximum
        $initialMinimum = $this->initialMinimum;
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
        $this->initialCurrentStepSize();
        $this->setCurrentChunkOrNull($initialChunk);
        */
    }

    /**
     * @param RealNumber $initialMinimum
     * @param RealNumber $stepSize
     * @return RealNumber
     */
    private function calculateInitialMaximum(RealNumber $initialMinimum, RealNumber $stepSize)
    {
        return ($this->calculateNextMaximum($initialMinimum, $stepSize)->minus($this->createNewRealNumber(1)));
    }

    /**
     * @param RealNumber $currentMinimum
     * @param RealNumber $stepSize
     * @return RealNumber
     */
    private function calculateNextMaximum(RealNumber $currentMinimum, RealNumber $stepSize)
    {
        return ($currentMinimum->plus($stepSize));
    }

    /**
     * @param RealNumber $currentMinimum
     * @return RealNumber
     */
    private function calculateNextMinimum(RealNumber $currentMinimum)
    {
        return ($currentMinimum->plus($this->createNewRealNumber(1)));
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

    /**
     * @param $number
     * @return RealNumber
     */
    private function createNewRealNumber($number)
    {
        return new RealNumber($number);
    }

    private function increaseCurrentStep()
    {
        ++$this->currentStep;
    }

    private function initialCurrentStepSize()
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
     * @param RealNumber $minimum
     */
    private function setInitialMinimum(RealNumber $minimum)
    {
        $this->initialMinimum = $minimum;
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
