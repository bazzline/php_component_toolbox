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

        $this->tryOutExperiment($trial, $times, $wait, $onSuccess, $onFailure, $expectedWasSuccessful, $successfulExecuted, $fallbackExecuted);
    }

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

        $this->tryOutExperiment($trial, $times, $wait, $onSuccess, $onFailure, $expectedWasSuccessful, $successfulExecuted, $fallbackExecuted);
    }

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

        $this->tryOutExperiment($trial, $times, $wait, $onSuccess, $onFailure, $expectedWasSuccessful, $successfulExecuted, $fallbackExecuted);
    }

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

        $this->tryOutExperiment($trial, $times, $wait, $onSuccess, $onFailure, $expectedWasSuccessful, $successfulExecuted, $fallbackExecuted);
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
     */
    private function tryOutExperiment($trial, $times, $wait, $onSuccess, $onFailure, $expectedWasSuccessful, &$successfulExecuted, &$fallbackExecuted)
    {
        $experiment = $this->getNewExperimentProcess();

        $experiment->prepareNewExperiment($trial, $times, $wait, $onSuccess, $onFailure);
        $wasSuccessful = $experiment->andTryIt();

        $this->assertEquals($expectedWasSuccessful, $wasSuccessful);

        if ($expectedWasSuccessful) {
            $this->assertFalse($fallbackExecuted);
            $this->assertTrue($successfulExecuted);
        } else {
            $this->assertFalse($successfulExecuted);
            $this->assertTrue($fallbackExecuted);
        }
    }
}
