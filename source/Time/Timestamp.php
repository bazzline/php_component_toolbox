<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since: 2015-11-05
 */
namespace Net\Bazzline\Component\Toolbox\Time;

class Timestamp
{
    public function getCurrentTimestamp(): int
    {
        return time();
    }

    public function __invoke(): int
    {
        return $this->getCurrentTimestamp();
    }

    public function __toString(): string
    {
        return (string) $this->getCurrentTimestamp();
    }
}
