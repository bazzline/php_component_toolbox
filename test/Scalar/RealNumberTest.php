<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-07-04
 */
namespace Test\Net\Bazzline\Component\Toolbox\Scalar;

use Net\Bazzline\Component\Toolbox\Scalar\RealNumber;
use stdClass;
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
                new stdClass(__LINE__)
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



    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function validConstructorArgumentProvider()
    {
        return array(
            'int'       => array(
                3,
                3
            ),
            'float'     => array(
                3.3,
                3.3
            ),
            'double'        => array(
                3.3,
                3.3
            ),
            'real_number'   => array(
                new RealNumber(3),
                new RealNumber(3)
            )
        );
    }



    /**
     * @dataProvider validConstructorArgumentProvider
     * @param int|float|double|number $constructorArgument
     * @param int|float|double|number $expectedValue
     * @throws \InvalidArgumentException
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testConstructorWithValidArguments($constructorArgument, $expectedValue)
    {
        $number     = new RealNumber($constructorArgument);
        $isEqual    = ((string) $number == $expectedValue);

        $this->assertTrue($isEqual);
    }

    public function testToScalar()
    {
        $number = new RealNumber(__LINE__);

        $areEqual       = ($number->__toString() == $number->toScalar());
        $areIdentical   = ($number->__toString() === $number->toScalar());
        
        $this->assertTrue($areEqual);
        $this->assertFalse($areIdentical);
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
