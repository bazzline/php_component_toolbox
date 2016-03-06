<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-07-30
 */

namespace Net\Bazzline\Component\Toolbox\Process;

class EnumerableDeferred
{
    /** @var callable */
    private $finisher;

    /** @var callable */
    private $initializer;

    /** @var int */
    private $iterator;

    /** @var int */
    private $iterationLimit;

    /** callable */
    private $processor;

    /**
     * @param callable $initializer
     * @param callable $processor
     * @param callable $finisher
     * @param int $limit
     */
    public function __construct($initializer, $processor, $finisher, $limit = 10)
    {
        $this->iterationLimit   = (int) $limit;
        $this->initializer      = $initializer;
        $this->processor        = $processor;
        $this->finisher         = $finisher;

        $this->initialize();
    }

    public function __destruct()
    {
        $this->finish();
    }

    /**
     * @param mixed $data,... unlimited optional number of additional variables [...]
     */
    public function __invoke($data = null)
    {
        call_user_func_array(array($this, 'increase'), func_get_args());
    }

    /**
     * @param mixed $data,... unlimited optional number of additional variables [...]
     */
    public function increase($data = null)
    {
        $arguments = func_get_args();
        $this->call($this->processor, $arguments);

        if ($this->limitReached($this->iterator, $this->iterationLimit)) {
            //finish
            $this->finish();
            //reinitialize
            $this->initialize();
        } else {
            ++$this->iterator;
        }
    }

    private function finish()
    {
        $this->call($this->finisher);
    }

    private function initialize()
    {
        $this->iterator = 0;
        $this->call($this->initializer);
    }

    /**
     * @param callable $callable
     * @param null|array $arguments
     */
    private function call($callable, $arguments = null)
    {
        if (!is_null($arguments)) {
            call_user_func_array($callable, $arguments);
        } else {
            call_user_func($callable);
        }
    }

    /**
     * @param int $iterator
     * @param int $limit
     * @return bool
     */
    private function limitReached($iterator, $limit)
    {
        return ($iterator >= $limit);
    }
}
