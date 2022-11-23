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
    private int $times;
    private int $wait;
    /** @var callable */
    private $trial;

    public function __construct()
    {
        $this->reset();
    }

    public function __invoke(): bool
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
    public function prepareNewExperiment(
        callable $trial,
        int $numberOfRetries = 3,
        int $millisecondsToWaitBetweenRetry = 250,
        callable $onSuccess = null,
        callable $onFailure = null
    ): self {
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
     * @throws Exception
     */
    public function andTryIt(): bool
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
    private function wasSuccessful($trial): bool
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
     * @return mixed the function result, or false on error.
     * @throws Exception
     */
    private function call(callable $callable): mixed
    {
        return call_user_func($callable);
    }

    private function reset(): void
    {
        $this->onFailure    = function () {};
        $this->onSuccess    = function () {};
        $this->wait         = 0;
        $this->times        = 0;
        $this->trial        = function () {};
    }
}
