<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Miners\Patterns;

class ArithmaticalPattern extends AbstractPattern implements PatternInterface
{
    protected $increment;

    public function __construct($seed = 0, $increment = 1)
    {
        parent::__construct($seed);
        $this->increment = $increment;
    }

    protected function nextValue(): int
    {
        return $this->current + $this->increment;
    }
}
