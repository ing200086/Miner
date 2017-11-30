<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class UnsolvedBlockData
{
    protected $version;
    protected $previousBlockHash;
    protected $merkleRoot;

    protected $time;
    protected $bits;

    protected $target;

    protected $partialHash;

    public function __construct($version, $previousBlockHash, $time, $bits, $merkleRoot, $target)
    {
        $this->version = $version;
        $this->time = $time;
        $this->bits = $bits;

        $this->previousBlockHash = $previousBlockHash;
        $this->merkleRoot = $merkleRoot;

        $this->target = $target;

        $this->partialHash = $this->version . $this->previousBlockHash . $this->merkleRoot .
                                $this->time . $this->bits;
    }

    public static function fromJson($inp)
    {
        return UnsolvedBlockBuilder::fromJson($inp);
    }

    public function previousBlockHash()
    {
        return $this->previousBlockHash;
    }

    public function time()
    {
        return $this->time;
    }

    public function version()
    {
        return $this->version;
    }

    public function bits()
    {
        return $this->bits;
    }

    public function merkleRoot()
    {
        return $this->merkleRoot;
    }

    public function target()
    {
        return $this->target;
    }
}
