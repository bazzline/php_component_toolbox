<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since: 2015-11-05
 */
namespace Net\Bazzline\Component\Toolbox\Time;

class Timestamp
{
    /**
     * @return int
     */
    public function getCurrentTimestamp()
    {
        return time();
    }

    /**
     * @return int
     */
    public function __invoke()
    {
        return $this->getCurrentTimestamp();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getCurrentTimestamp();
    }
}
