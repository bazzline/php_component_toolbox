<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-07-04
 */
namespace Test\Net\Bazzline\Component\Toolbox\Scalar;

use Net\Bazzline\Component\Toolbox\Scalar\RealNumber;
use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class RealNumberTest extends AbstractTestCase
{
    /**
     * @return array
     */
    public function invalidConstructorArgumentProvider()
    {
        return array(
            'boolean'   => array(
                true
            ),
            'string'    => array(
                'string'
            ),
            'object'    => array(
                new RealNumber(__LINE__)
            )
        );
    }

    /**
     * @dataProvider invalidConstructorArgumentProvider
     * @param $constructorArgument
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage provided value is not a number
     */
    public function testConstructorWithInvalidArguments($constructorArgument)
    {
        new RealNumber($constructorArgument);
    }

    public function testComparison()
    {
        $three  = new RealNumber(3);
        $four   = new RealNumber(4);

        $this->assertFalse($three->isEqual($four));

        $this->assertFalse($three->isGreaterThan($four));
        $this->assertFalse($three->isGreaterThanOrEqual($four));

        $this->assertTrue($four->isGreaterThan($three));
        $this->assertTrue($four->isGreaterThanOrEqual($three));

        $this->assertFalse($four->isLessThan($three));
        $this->assertFalse($four->isLessThanOrEqual($three));

        $this->assertTrue($three->isLessThan($four));
        $this->assertTrue($three->isLessThanOrEqual($four));

        $this->assertTrue($four->isEqual($four));
        $this->assertTrue($four->isGreaterThanOrEqual($four));
        $this->assertTrue($four->isLessThanOrEqual($four));

        $this->assertFalse($four->isGreaterThan($four));
        $this->assertFalse($four->isLessThan($four));
    }
}