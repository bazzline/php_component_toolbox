<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-07-30
 */

namespace Net\Bazzline\Component\Toolbox\Process;

class EnumerableDeferred
{
    /** @var callable */
    private $finisher;
    /** @var callable */
    private $initializer;
    private int $iterator;
    private int $iterationLimit;
    /** callable */
    private $processor;

    /**
     * @param callable $initializer
     * @param callable $processor
     * @param callable $finisher
     * @param int $limit
     */
    public function __construct(
        callable $initializer,
        callable $processor,
        callable $finisher,
        int $limit = 10
    ) {
        $this->iterationLimit   = (int) $limit;
        $this->initializer      = $initializer;
        $this->processor        = $processor;
        $this->finisher         = $finisher;

        $this->initialize();
    }

    public function __destruct()
    {
        $this->finish();
    }

    /**
     * @param mixed $data,... unlimited optional number of additional variables [...]
     */
    public function __invoke(mixed $data = null): void
    {
        call_user_func_array(
            [
                $this,
                'increase'
            ],
            func_get_args()
        );
    }

    /**
     * @param mixed $data,... unlimited optional number of additional variables [...]
     */
    public function increase(mixed $data = null): void
    {
        $arguments = func_get_args();
        $this->call($this->processor, $arguments);

        if ($this->limitReached($this->iterator, $this->iterationLimit)) {
            //finish
            $this->finish();
            //reinitialize
            $this->initialize();
        } else {
            ++$this->iterator;
        }
    }

    private function finish(): void
    {
        $this->call($this->finisher);
    }

    private function initialize(): void
    {
        $this->iterator = 0;
        $this->call($this->initializer);
    }

    /**
     * @param callable $callable
     * @param null|array $arguments
     */
    private function call(
        callable $callable,
        array $arguments = null
    ): void {
        if (!is_null($arguments)) {
            call_user_func_array(
                $callable,
                $arguments
            );
        } else {
            call_user_func($callable);
        }
    }

    private function limitReached(
        int $iterator,
        int $limit
    ): bool {
        return ($iterator >= $limit);
    }
}
