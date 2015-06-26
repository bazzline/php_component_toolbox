<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-26
 */

namespace Test\Net\Bazzline\Component\Toolbox;

use Net\Bazzline\Component\Toolbox\HashMap\Combine;
use PHPUnit_Framework_TestCase;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @return Combine
     */
    protected function getHashMapCombine()
    {
        return new Combine();
    }
}