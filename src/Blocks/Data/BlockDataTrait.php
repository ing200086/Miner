<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Blocks\Data;

use Ing200086\Miner\Hashes\HashInterface;

trait BlockDataTrait
{
    protected $version;
    protected $previousBlockHash;
    protected $merkleRoot;

    protected $time;
    protected $bits;

    protected $target;

    public function previousBlockHash(): HashInterface
    {
        return $this->previousBlockHash;
    }

    public function time(): HashInterface
    {
        return $this->time;
    }

    public function version(): HashInterface
    {
        return $this->version;
    }

    public function bits(): HashInterface
    {
        return $this->bits;
    }

    public function merkleRoot(): HashInterface
    {
        return $this->merkleRoot;
    }

    public function target(): HashInterface
    {
        return $this->target;
    }
}
