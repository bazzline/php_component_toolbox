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
    private int|float $value;

    /**
     * Number constructor.
     *
     * @param float|int|RealNumber $value
     * @throws InvalidArgumentException
     */
    public function __construct(RealNumber|float|int $value)
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

    public function toScalar(): int|float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function isEqual(RealNumber $number): bool
    {
        return ($this === $number);
    }

    public function isGreaterThan(RealNumber $number): bool
    {
        return ($this > $number);
    }

    public function isGreaterThanOrEqual(RealNumber $number): bool
    {
        return ($this >= $number);
    }

    public function isLessThan(RealNumber $number): bool
    {
        return ($this->toScalar() < $number->toScalar());
    }

    public function isLessThanOrEqual(RealNumber $number): bool
    {
        return ($this <= $number);
    }



    /**
     * @param RealNumber $number
     * @return RealNumber
     * @throws InvalidArgumentException
     */
    public function minus(RealNumber $number): RealNumber
    {
        return new self($this->value - $number->value);
    }



    /**
     * @param RealNumber $number
     * @return RealNumber
     * @throws InvalidArgumentException
     */
    public function plus(RealNumber $number): RealNumber
    {
        return new self($this->value + $number->value);
    }
}
