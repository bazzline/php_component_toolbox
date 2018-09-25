<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-09
 */
namespace Test\Net\Bazzline\Component\Toolbox\Process;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;
use Exception;

/**
 * Class ExperimentTest
 * @package Test\Net\Bazzline\Component\Toolbox\Process
 * @todo easy up setup for each test case
 */
class ExperimentTest extends AbstractTestCase
{
    /**
     * @throws \InvalidArgumentException
     */
    public function testIsSuccessfulOnLastRun()
    {
        $iterator           = 0;
        $successfulExecuted = false;
        $fallbackExecuted   = false;

        $trial = function () use (&$iterator) {
            ++$iterator;
            return ($iterator > 2);
        };
        $times  = 3;
        $wait   = 100;
        $onSuccess = function () use (&$successfulExecuted) {
            $successfulExecuted = true;
        };
        $onFailure = function () use (&$fallbackExecuted) {
            $fallbackExecuted = true;
        };
        $expectedWasSuccessful = true;

        $this->tryOutExperiment(
            $trial,
            $times,
            $wait,
            $onSuccess,
            $onFailure,
            $expectedWasSuccessful,
            $successfulExecuted,
            $fallbackExecuted
        );
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testIsSuccessfulOnFirstRun()
    {
        $iterator           = 0;
        $successfulExecuted = false;
        $fallbackExecuted   = false;

        $trial = function () use (&$iterator) {
            ++$iterator;
            return ($iterator > 0);
        };
        $times  = 3;
        $wait   = 100;
        $onSuccess = function () use (&$successfulExecuted) {
            $successfulExecuted = true;
        };
        $onFailure = function () use (&$fallbackExecuted) {
            $fallbackExecuted = true;
        };
        $expectedWasSuccessful = true;

        $this->tryOutExperiment(
            $trial,
            $times,
            $wait,
            $onSuccess,
            $onFailure,
            $expectedWasSuccessful,
            $successfulExecuted,
            $fallbackExecuted
        );
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testIsNeverSuccessfulByReturningFalse()
    {
        $successfulExecuted = false;
        $fallbackExecuted   = false;

        $trial = function () {
            return false;
        };
        $times  = 3;
        $wait   = 100;
        $onSuccess = function () use (&$successfulExecuted) {
            $successfulExecuted = true;
        };
        $onFailure = function () use (&$fallbackExecuted) {
            $fallbackExecuted = true;
        };
        $expectedWasSuccessful = false;

        $this->tryOutExperiment(
            $trial,
            $times,
            $wait,
            $onSuccess,
            $onFailure,
            $expectedWasSuccessful,
            $successfulExecuted,
            $fallbackExecuted
        );
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testIsNeverSuccessfulByThrowingException()
    {
        $successfulExecuted = false;
        $fallbackExecuted   = false;

        $trial = function () {
            throw new Exception(
                'boom'
            );
        };
        $times  = 3;
        $wait   = 100;
        $onSuccess = function () use (&$successfulExecuted) {
            $successfulExecuted = true;
        };
        $onFailure = function () use (&$fallbackExecuted) {
            $fallbackExecuted = true;
        };
        $expectedWasSuccessful = false;

        $this->tryOutExperiment(
            $trial,
            $times,
            $wait,
            $onSuccess,
            $onFailure,
            $expectedWasSuccessful,
            $successfulExecuted,
            $fallbackExecuted
        );
    }



    /**
     * @param callback $trial
     * @param int $times
     * @param int $wait
     * @param callback $onSuccess
     * @param callback $onFailure
     * @param bool $expectedWasSuccessful
     * @param bool $successfulExecuted
     * @param bool $fallbackExecuted
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    private function tryOutExperiment(
        $trial,
        int $times,
        int $wait,
        $onSuccess,
        $onFailure,
        bool $expectedWasSuccessful,
        bool &$successfulExecuted,
        bool &$fallbackExecuted
    ) {
        $experiment = $this->getNewExperimentProcess();

        $experiment->prepareNewExperiment(
            $trial,
            $times,
            $wait,
            $onSuccess,
            $onFailure
        );
        $wasSuccessful = $experiment->andTryIt();

        self::assertEquals(
            $expectedWasSuccessful,
            $wasSuccessful
        );

        if ($expectedWasSuccessful) {
            self::assertFalse($fallbackExecuted);
            self::assertTrue($successfulExecuted);
        } else {
            self::assertFalse($successfulExecuted);
            self::assertTrue($fallbackExecuted);
        }
    }
}
