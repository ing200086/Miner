<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Miners\Patterns;

class ArithmaticalPattern
{
    protected $current;
    protected $increment;

    public function __construct($seed = 0, $increment = 1)
    {
        $this->current = $seed;
        $this->increment = $increment;
    }

    public function next()
    {
        $next = $this->current + $this->increment;

        if ($next > 2147483647) {
            $next = 0;
        }

        $this->current = $next;
    }

    public function current()
    {
        return $this->current;
    }
}
