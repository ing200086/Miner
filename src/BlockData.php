<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class BlockData
{
    protected $previousBlockHash;
    protected $transactions;

    protected function __construct($previousBlockHash)
    {
        $this->previousBlockHash = $previousBlockHash;
    }

    public static function fromJson($json)
    {
        return new static($json['previousblockhash']);
    }

    public function previousBlockHash()
    {
        return $this->previousBlockHash;
    }
}
