<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Miners\Patterns;

abstract class AbstractPattern implements PatternInterface
{
    protected $current;
    protected $seed;
    protected $maxValue;

    public function __construct($seed, $maxValue = 2147483647)
    {
        $this->seed = $seed;
        $this->maxValue($maxValue);
        $this->reset();
    }

    abstract protected function nextValue(): int;

    public function next(): void
    {
        $next = $this->nextValue();

        if ($this->isOutOfBounds($next)) {
            $next = $this->nextReset($next);
        }

        $this->current = $next;
    }

    public function reset()
    {
        $this->current = $this->seed;
    }

    public function maxValue($maxValue)
    {
        $this->maxValue = $maxValue;
    }

    protected function isOutOfBounds($value)
    {
        return $value > $this->maxValue;
    }

    protected function nextReset($value)
    {
        return $value - $this->maxValue - 1;
    }

    public function current(): int
    {
        return $this->current;
    }
}
