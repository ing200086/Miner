<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Miners;

class ArithmaticalMiner extends AbstractMiner
{
    protected $increment;

    public function __construct($increment)
    {
        $this->increment = $increment;
    }

    protected function nextNonce($current)
    {
        $next = $current + $this->increment;

        if ($next > 2147483647) {
            $next = 0;
        }

        return $next;
    }
}
