<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-09
 */
namespace Test\Net\Bazzline\Component\Toolbox\Process;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

/**
 * Class ExperimentTest
 * @package Test\Net\Bazzline\Component\Toolbox\Process
 */
class ExperimentTest extends AbstractTestCase
{
    /** @var int */
    private $iterator;

    /** @var bool */
    private $fallbackExecuted;

    public function experiments()
    {
        $iterator           = &$this->iterator;
        $fallbackExecuted   = &$this->fallbackExecuted;

        return array(
            'last run is successful' => array(
                'times'             => 3,
                'test'              => function () use (&$iterator) {
                    ++$iterator;
                    return ($iterator > 2);
                },
                'wait'              => 100,
                'fallback'          => function () use (&$fallbackExecuted) {
                    $fallbackExecuted = true;
                },
                'wasSuccessful'     => true
            ),
            'first run is successful' => array(
                'times'             => 3,
                'test'              => function () use (&$iterator) {
                    ++$iterator;
                    return ($iterator > 0);
                },
                'wait'              => 500,
                'fallback'          => function () use (&$fallbackExecuted) {
                    $fallbackExecuted = true;
                },
                'wasSuccessful'     => true
            )
        );
    }

    /**
     * @dataProvider experiments
     * @param int $times
     * @param callback $test
     * @param int $wait
     * @param callback $fallback
     * @param bool $expectedWasSuccessful
     */
    public function testExperiment($times, $test, $wait, $fallback, $expectedWasSuccessful)
    {
        $this->iterator         = 0;
        $this->fallbackExecuted = false;

        $experiment = $this->getNewExperimentProcess();

        $wasSuccessful = $experiment->attempt($times)
            ->toExecute($test)
            ->andWaitFor($wait)
            ->orExecute($fallback)
            ->andFinallyStartTheExperiment();

        $this->assertEquals($expectedWasSuccessful, $wasSuccessful);
        $this->assertFalse($this->fallbackExecuted);
    }
}