<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Miners;

use Ing200086\Miner\Miners\Patterns\ArithmaticalPattern;

class ArithmaticalMiner extends AbstractMiner
{
    protected $pattern;

    public function __construct(ArithmaticalPattern $pattern)
    {
        $this->pattern = $pattern;
    }

    public function run()
    {
        for ($this->cycles = 0; $this->cycles < $this->maxCycles; $this->cycles++) {
            if ($this->block->testNonce($this->pattern->current())) {
                $this->valid = $this->pattern->current();
                break;
            }
            $this->pattern->next();
        }
    }
}
