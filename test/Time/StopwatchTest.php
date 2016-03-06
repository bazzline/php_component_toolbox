<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-01
 */
namespace Test\Net\Bazzline\Component\Toolbox\Time;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class StopwatchTest extends AbstractTestCase
{
    public function testStopAndGetRuntimeWithoutStartingTheWatch()
    {
        $stopwatch = $this->getNewStopwatchTime();

        $this->assertEquals(0, $stopwatch->stop());
        $this->assertEquals(0, $stopwatch->getRuntime());
    }

    public function testStopAndGetRuntimeAfterStartingTheWatch()
    {
        $stopwatch = $this->getNewStopwatchTime();

        $stopwatch->start();
        $stopwatch->stop();

        $this->assertGreaterThanOrEqual(0, $stopwatch->stop());
        $this->assertGreaterThanOrEqual(0, $stopwatch->getRuntime());
    }
}