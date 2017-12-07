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
    protected $cycles;
    protected $maxCycles = 10000;

    public function load(UnclaimedInterface $block)
    {
        $this->block = $block;
        return $this;
    }

    public function nugget()
    {
        return $this->block;
    }

    public function key()
    {
        return $this->valid;
    }

    public function maxCycles($cycles)
    {
        $this->maxCycles = $cycles;
        return $this;
    }

    public function cycles()
    {
        return $this->cycles;
    }
}
