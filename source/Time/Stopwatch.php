<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-11-01
 */
namespace Net\Bazzline\Component\Toolbox\Time;

class Stopwatch
{
    private int $runtimeInSeconds = 0;
    private int $timeStampOfStart = 0;

    public function getRuntime(): int
    {
        return $this->runtimeInSeconds;
    }

    public function stop(): int
    {
        $this->calculateRuntime();

        return $this->getRuntime();
    }

    public function start(): self
    {
        $this->runtimeInSeconds = 0;
        $this->timeStampOfStart = $this->getCurrentTimeStamp();

        return $this;
    }

    private function calculateDifference(
        int $start,
        int $end
    ): int {
        return ($end - $start);
    }

    private function calculateRuntime(): void
    {
        if ($this->timeStampOfStart > 0) {
            $this->runtimeInSeconds = $this->calculateDifference(
                $this->timeStampOfStart,
                $this->getCurrentTimeStamp()
            );
        }
    }

    private function getCurrentTimeStamp(): int
    {
        return time();
    }
}
