<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Miners;

use Ing200086\Miner\Blocks\UnclaimedInterface;

abstract class AbstractMiner
{
    protected $valid;
    protected $block;
    protected $seed;
    protected $cycles;
    protected $maxCycles = 20;

    public function load(UnclaimedInterface $block)
    {
        $this->block = $block;
    }

    public function nugget()
    {
        return $this->block;
    }

    public function run()
    {
        $current = $this->seed;

        for ($this->cycles = 0; $this->cycles < $this->maxCycles; $this->cycles++) {
            if ($this->block->testNonce($current)) {
                break;
            }
            $current = $this->nextNonce($current);
        }

        $this->valid = $current;
    }

    abstract protected function nextNonce($current);

    public function seed($value)
    {
        $this->seed = $value;
    }

    public function key()
    {
        return $this->valid;
    }

    public function cycles()
    {
        return $this->cycles;
    }
}
