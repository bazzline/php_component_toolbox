<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-09
 */
namespace Test\Net\Bazzline\Component\Toolbox\Process;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;
use stdClass;

/**
 * Class ExperimentTest
 * @package Test\Net\Bazzline\Component\Toolbox\Process
 */
class ExperimentTest extends AbstractTestCase
{
    /** @var stdClass */
    private $state;

    public function testExperiments()
    {
        $this->markTestSkipped();
        $this->setUpState();
        foreach ($this->experimentTestCases() as $name => $testCase) {
            $testCase['name'] = $name;
            call_user_func_array(array($this, 'tryOutExperiment'), $testCase);
            $this->setUpState();
        }
    }

    /**
     * @return array
     */
    private function experimentTestCases()
    {
        $state = $this->state;

        return array(
            'last run is successful' => array(
                'trial'             => function () use ($state) {
                    ++$state->iterator;
                    return ($state->iterator > 2);
                },
                'times'             => 3,
                'wait'              => 100,
                'onSuccess'         => function () use ($state) {
                    $state->successfulExecuted = true;
                },
                'onFailure'         => function () use ($state) {
                    $state->fallbackExecuted = true;
                },
                'wasSuccessful'     => true
            ),
            'first run is successful' => array(
                'trial'             => function () use ($state) {
                    ++$state->iterator;
                    return ($state->iterator > 0);
                },
                'times'             => 3,
                'wait'              => 100,
                'onSuccess'         => function () use ($state) {
                    $state->successfulExecuted = true;
                },
                'onFailure'         => function () use ($state) {
                    $state->fallbackExecuted = true;
                },
                'wasSuccessful'     => true
            )
        );
    }

    /**
     * @param callback $trial
     * @param int $times
     * @param int $wait
     * @param null|callback $onSuccess
     * @param null|callback $onFailure
     * @param bool $expectedWasSuccessful
     * @param string $name
     */
    private function tryOutExperiment($trial, $times, $wait, $onSuccess = null, $onFailure = null, $expectedWasSuccessful, $name)
    {
        $experiment = $this->getNewExperimentProcess();

        $experiment->prepareNewExperiment($trial, $times, $wait, $onSuccess, $onFailure);
        $wasSuccessful = $experiment->andTryIt();

        $this->assertEquals($expectedWasSuccessful, $wasSuccessful, $name);

        if ($expectedWasSuccessful) {
            $this->assertFalse($this->state->fallbackExecuted, $name);
            $this->assertTrue($this->state->successfulExecuted, $name);
        } else {
            $this->assertFalse($this->state->successfulExecuted, $name);
            $this->assertTrue($this->state->fallbackExecuted, $name);
        }
    }

    private function setUpState()
    {
        $this->state                        = new stdClass();
        $this->state->iterator              = 0;
        $this->state->fallbackExecuted      = false;
        $this->state->successfulExecuted    = false;
    }
}
