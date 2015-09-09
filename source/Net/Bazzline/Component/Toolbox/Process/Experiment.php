<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-09
 */
namespace Net\Bazzline\Component\Toolbox\Process;

/**
 * Class Experiment
 * @package Net\Bazzline\Component\Toolbox\Process
 */
class Experiment
{
    /** @var callable */
    private $experiment;

    /** @var callable */
    private $fallback;

    /** @var int */
    private $times;

    /** @var int */
    private $wait;

    public function __construct()
    {
        $this->experiment   = function () {};
        $this->fallback     = function () {};
        $this->times        = 0;
        $this->wait         = 0;
    }

    /**
     * @return bool
     */
    public function __invoke()
    {
        return $this->andFinallyStartTheExperiment();
    }

    /**
     * @param callable $callable - needs to return true on success or false for a next try
     * @return $this
     */
    public function toExecute($callable)
    {
        $this->experiment = $callable;

        return $this;
    }

    /**
     * @param int $times
     * @return $this
     */
    public function attempt($times)
    {
        $this->times = $times;

        return $this;
    }

    /**
     * @param int $milliseconds
     * @return $this
     */
    public function andWaitFor($milliseconds)
    {
        $this->wait = $milliseconds;

        return $this;
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function orExecute($callable)
    {
        $this->fallback = $callable;

        return $this;
    }

    /**
     * @return bool
     */
    public function andFinallyStartTheExperiment()
    {
        $experiment         = $this->experiment;
        $iterator           = 0;
        $fallback           = $this->fallback;
        $times              = $this->times;
        $wait               = $this->wait;
        $wasNotSuccessful   = true;

        while ($iterator < $times) {
            if ($experiment()) {
                $wasNotSuccessful = false;
                break;
            }
            ++$iterator;
            usleep($wait);
        }

        if ($wasNotSuccessful) {
            $fallback();
        }

        return (!$wasNotSuccessful);
    }
}