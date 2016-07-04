<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-07-04
 */
namespace Net\Bazzline\Component\Toolbox\Scalar;

use InvalidArgumentException;

class RealNumber
{
    /** @var int|float|double */
    private $value;

    /**
     * Number constructor.
     *
     * @param int|float|double $value
     */
    public function __construct($value)
    {
        if (is_numeric($value)) {
            $this->value = $value;
        } else {
            throw new InvalidArgumentException(
                'provided value is not a number'
            );
        }
    }

    /**
     * @return float|int|string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * @param RealNumber $number
     *
     * @return bool
     */
    public function isEqual(RealNumber $number)
    {
        return ($this == $number);
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
        return ($this < $number);
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
}