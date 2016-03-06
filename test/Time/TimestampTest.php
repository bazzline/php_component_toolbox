<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-05
 */
namespace Test\Net\Bazzline\Component\Toolbox\Time;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class TimestampTest extends AbstractTestCase
{
    public function testTimestamp()
    {
        $timestamp          = $this->getNewTimestamp();
        $currentTimestamp   = time();

        $this->assertGreaterThanOrEqual($currentTimestamp, $timestamp->getCurrentTimestamp());
        $this->assertGreaterThanOrEqual($currentTimestamp, $timestamp());
        $this->assertGreaterThanOrEqual($currentTimestamp, (string) $timestamp);
    }
}
