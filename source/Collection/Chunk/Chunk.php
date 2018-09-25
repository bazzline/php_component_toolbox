<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-08-03
 */
namespace Net\Bazzline\Component\Toolbox\Collection\Chunk;

class Chunk
{
    /** @var int */
    private $maximum;

    /** @var int */
    private $minimum;

    /**
     * @param int $maximum
     * @param int $minimum
     */
    public function __construct(
        int $maximum,
        int $minimum
    ) {
        $this->maximum  = (int) $maximum;
        $this->minimum  = (int) $minimum;
    }

    public function minimum(): int
    {
        return $this->minimum;
    }

    public function maximum(): int
    {
        return $this->maximum;
    }
}
