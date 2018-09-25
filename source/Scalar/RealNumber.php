<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-07-04
 */
namespace Net\Bazzline\Component\Toolbox\Scalar;

use InvalidArgumentException;
use SebastianBergmann\CodeCoverage\Report\PHP;

class RealNumber
{
    /** @var int|float|double */
    private $value;



    /**
     * Number constructor.
     *
     * @param int|float|double|RealNumber $value
     * @throws InvalidArgumentException
     */
    public function __construct($value)
    {
        if (is_numeric($value)) {
            $this->value = $value;
        } else if ($value instanceof RealNumber) {
            $this->value = (string) $value;
        } else {
            throw new InvalidArgumentException(
                'provided value is not a number'
            );
        }
    }

    /**
     * @return int|float|double
     */
    public function toScalar()
    {
        return $this->value;
    }

    /**
     * @return float|int|string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * @param RealNumber $number
     *
     * @return bool
     */
    public function isEqual(RealNumber $number)
    {
        return ($this === $number);
    }

    /**
     * @param RealNumber $number
     *
     * @return bool
     */
    public function isGreaterThan(RealNumber $number)
    {
        return ($this > $number);
    }

    /**
     * @param RealNumber $number
     *
     * @return bool
     */
    public function isGreaterThanOrEqual(RealNumber $number)
    {
        return ($this >= $number);
    }

    /**
     * @param RealNumber $number
     *
     * @return bool
     */
    public function isLessThan(RealNumber $number)
    {
        return ($this->toScalar() < $number->toScalar());
    }

    /**
     * @param RealNumber $number
     *
     * @return bool
     */
    public function isLessThanOrEqual(RealNumber $number)
    {
        return ($this <= $number);
    }



    /**
     * @param RealNumber $number
     * @return RealNumber
     * @throws InvalidArgumentException
     */
    public function minus(RealNumber $number)
    {
        return new self($this->value - $number->value);
    }



    /**
     * @param RealNumber $number
     * @return RealNumber
     * @throws InvalidArgumentException
     */
    public function plus(RealNumber $number)
    {
        return new self($this->value + $number->value);
    }
}
