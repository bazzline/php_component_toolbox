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
    public function __construct($maximum, $minimum)
    {
        $this->maximum  = (int) $maximum;
        $this->minimum  = (int) $minimum;
    }

    /**
     * @return int
     */
    public function minimum()
    {
        return $this->minimum;
    }

    /**
     * @return int
     */
    public function maximum()
    {
        return $this->maximum;
    }
}
