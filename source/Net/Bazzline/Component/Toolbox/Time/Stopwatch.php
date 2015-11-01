<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-01
 */
namespace Net\Bazzline\Component\Toolbox\Time;

class Stopwatch
{
    /** @var int */
    private $runtimeInSeconds = 0;

    /** @var int */
    private $timeStampOfStart = 0;

    /**
     * @return int
     */
    public function getRuntime()
    {
        return $this->runtimeInSeconds;
    }

    /**
     * @return int
     */
    public function stop()
    {
        if (is_null($this->runtimeInSeconds)) {
            $this->calculateRuntime();
        }

        return $this->getRuntime();
    }

    /**
     * @return $this
     */
    public function start()
    {
        $this->runtimeInSeconds = null;
        $this->timeStampOfStart = $this->getCurrentTimeStamp();

        return $this;
    }

    /**
     * @param int $start
     * @param int $end
     * @return int
     */
    private function calculateDifference($start, $end)
    {
        return ($end - $start);
    }

    private function calculateRuntime()
    {
        $this->runtimeInSeconds = $this->calculateDifference(
            $this->timeStampOfStart,
            $this->getCurrentTimeStamp()
        );
    }

    /**
     * @return int
     */
    private function getCurrentTimeStamp()
    {
        return time();
    }
}