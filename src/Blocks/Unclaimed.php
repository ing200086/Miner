<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Blocks;

use Ing200086\Miner\Blocks\Data\BlockDataInterface;
use Ing200086\Miner\Hashes\Hash;
use Ing200086\Miner\Hashes\HashCreator;
use Ing200086\Miner\Hashes\HashInterface;

class Unclaimed
{
    protected $hashCreator;
    protected $data;

    protected $hash;
    protected $partialHash;

    public function __construct(BlockDataInterface $data)
    {
        $this->hashCreator = new HashCreator();
        $this->data = $data;

        $this->hash = [];

        $this->partialHash = $this->data->version() . $this->data->previousBlockHash() . $this->data->merkleRoot() .
                                $this->data->time() . $this->data->bits();
    }

    protected function generateHash(string $partialHash, string $nonce): HashInterface
    {
        $fullHash = hex2bin($partialHash . $nonce);

        $pass1Hash = hex2bin(hash('sha256', $fullHash));
        $pass2Hash = hash('sha256', $pass1Hash);

        return $this->hashCreator::hex($pass2Hash);
    }

    public function testNonce(HashInterface $nonce)
    {
        $shot = $this->generateHash($this->partialHash, $nonce->endian()->little()->into()->hex())->endian()->little();

        return $shot->into()->decimal() < $this->data->target()->into()->decimal();
    }
}
