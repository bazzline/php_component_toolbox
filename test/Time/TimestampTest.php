<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-05
 */
namespace Test\Net\Bazzline\Component\Toolbox\Time;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class TimestampTest extends AbstractTestCase
{
    public function testTimestamp(): void
    {
        $timestamp          = $this->getNewTimestamp();
        $currentTimestamp   = time();

        self::assertGreaterThanOrEqual($currentTimestamp, $timestamp->getCurrentTimestamp());
        self::assertGreaterThanOrEqual($currentTimestamp, $timestamp());
        self::assertGreaterThanOrEqual($currentTimestamp, (string) $timestamp);
    }
}
