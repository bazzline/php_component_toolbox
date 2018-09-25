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

    public function getRuntime(): int
    {
        return $this->runtimeInSeconds;
    }

    public function stop(): int
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

    private function calculateDifference(
        int $start,
        int $end
    ): int {
        return ($end - $start);
    }

    private function calculateRuntime()
    {
        $this->runtimeInSeconds = $this->calculateDifference(
            $this->timeStampOfStart,
            $this->getCurrentTimeStamp()
        );
    }

    private function getCurrentTimeStamp(): int
    {
        return time();
    }
}
