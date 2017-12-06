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
use Ing200086\Miner\Hashes\HashCreator;

class ArithmaticalMiner
{
    protected $current;
    protected $valid;
    protected $block;
    protected $increment;

    public function __construct($increment)
    {
        $this->increment = $increment;
    }

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
        $nonce = HashCreator::decimal($this->current);

        if ($this->block->testNonce($nonce)) {
            $this->valid = $this->current;
        }
    }

    public function seed($value)
    {
        $this->current = $value;
    }

    public function key()
    {
        return $this->valid;
    }
}
