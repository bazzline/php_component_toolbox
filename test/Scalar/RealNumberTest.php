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
        return [
            'boolean'   => [
                true
            ],
            'string'    => [
                'string'
            ],
            'object'    => [
                new stdClass()
            ]
        ];
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
        return [
            'int'       => [
                3,
                3
            ],
            'float'     => [
                3.3,
                3.3
            ],
            'double'        => [
                3.3,
                3.3
            ],
            'real_number'   => [
                new RealNumber(3),
                new RealNumber(3)
            ]
        ];
    }



    /**
     * @dataProvider validConstructorArgumentProvider
     * @param int|float|double|number $constructorArgument
     * @param int|float|double|number $expectedValue
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    public function testConstructorWithValidArguments($constructorArgument, $expectedValue)
    {
        $number     = new RealNumber($constructorArgument);
        $isEqual    = ((string) $number == $expectedValue);

        self::assertTrue($isEqual);
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    public function testToScalar()
    {
        $number = new RealNumber(__LINE__);

        $areEqual       = ($number->__toString() == $number->toScalar());
        $areIdentical   = ($number->__toString() === $number->toScalar());
        
        self::assertTrue($areEqual);
        self::assertFalse($areIdentical);
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    public function testComparison()
    {
        $three  = new RealNumber(3);
        $four   = new RealNumber(4);

        self::assertFalse($three->isEqual($four));

        self::assertFalse($three->isGreaterThan($four));
        self::assertFalse($three->isGreaterThanOrEqual($four));

        self::assertTrue($four->isGreaterThan($three));
        self::assertTrue($four->isGreaterThanOrEqual($three));

        self::assertFalse($four->isLessThan($three));
        self::assertFalse($four->isLessThanOrEqual($three));

        self::assertTrue($three->isLessThan($four));
        self::assertTrue($three->isLessThanOrEqual($four));

        self::assertTrue($four->isEqual($four));
        self::assertTrue($four->isGreaterThanOrEqual($four));
        self::assertTrue($four->isLessThanOrEqual($four));

        self::assertFalse($four->isGreaterThan($four));
        self::assertFalse($four->isLessThan($four));
    }
}
