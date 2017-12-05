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
use Ing200086\Miner\Hashes\HashInterface;

class Unclaimed
{
    protected $data;

    protected $hash;
    protected $partialHash;

    public function __construct(BlockDataInterface $data)
    {
        $this->data = $data;

        $this->hash = [];

        $this->partialHash = $this->data->version() . $this->data->previousBlockHash() . $this->data->merkleRoot() .
                                $this->data->time() . $this->data->bits();
    }

    protected static function generateHash(string $partialHash, HashInterface $nonce): HashInterface
    {
        $fullHash = hex2bin($partialHash . $nonce);

        $pass1Hash = hex2bin(hash('sha256', $fullHash));
        $pass2Hash = hash('sha256', $pass1Hash);

        return Hash::from()::hex($pass2Hash);
    }

    public function testNonce(HashInterface $nonce)
    {
        $nonce = $nonce->endian()->little();

        $shot = self::generateHash($this->partialHash, $nonce)->endian()->little();
        $target = $this->data->target();

        return hexdec($shot) < hexdec($target);
    }
}
