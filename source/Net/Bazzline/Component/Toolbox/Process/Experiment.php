<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-09
 */
namespace Net\Bazzline\Component\Toolbox\Process;

use Exception;
use InvalidArgumentException;

/**
 * Class Experiment
 * @package Net\Bazzline\Component\Toolbox\Process
 */
class Experiment
{
    /** @var callable */
    private $onFailure;

    /** @var callable */
    private $onSuccess;

    /** @var int */
    private $times;

    /** @var int */
    private $wait;

    /** @var callable */
    private $trial;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * @return bool
     */
    public function __invoke()
    {
        return $this->andTryIt();
    }

    /**
     * @param callable $trial - must return bool or throw an exception on error
     * @param int $numberOfRetries
     * @param int $millisecondsToWaitBetweenRetry
     * @param null|callable $onSuccess
     * @param null|callable $onFailure
     * @return $this
     * @throws InvalidArgumentException
     */
    public function prepareNewExperiment($trial, $numberOfRetries = 3, $millisecondsToWaitBetweenRetry = 250, $onSuccess = null, $onFailure = null)
    {
        $this->reset();

        if (is_callable($onFailure)) {
            $this->onFailure = $onFailure;
        }
        if (is_callable($onSuccess)) {
            $this->onSuccess = $onSuccess;
        }
        $this->wait     = $millisecondsToWaitBetweenRetry;
        $this->times    = $numberOfRetries;

        if (is_callable($trial)) {
            $this->trial = $trial;
        } else {
            throw new InvalidArgumentException(
                'trial must be a callable'
            );
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function andTryIt()
    {
        $fallback           = $this->onFailure;
        $iterator           = 0;
        $success            = $this->onSuccess;
        $times              = $this->times;
        $trial              = $this->trial;
        $wait               = $this->wait;
        $wasNotSuccessful   = true;

        while ($iterator < $times) {
            if ($this->wasSuccessful($trial)){
                $wasNotSuccessful = false;
                break;
            }
            ++$iterator;
            usleep($wait);
        }

        if ($wasNotSuccessful) {
            $this->call($fallback);
        } else {
            $this->call($success);
        }

        return (!$wasNotSuccessful);
    }

    /**
     * @param callable $trial
     * @return bool
     */
    private function wasSuccessful($trial)
    {
        try {
            $wasSuccessful = $this->call($trial);
        } catch (Exception $exception) {
            $wasSuccessful = false;
        }

        return $wasSuccessful;
    }

    /**
     * @param callable $callable
     * @return bool
     * @throws Exception
     */
    private function call($callable)
    {
        return call_user_func($callable);
    }

    private function reset()
    {
        $this->onFailure    = function () {};
        $this->onSuccess    = function () {};
        $this->wait         = 0;
        $this->times        = 0;
        $this->trial        = function () {};
    }
}
