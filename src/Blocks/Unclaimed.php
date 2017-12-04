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
use Ing200086\Miner\Hash;
use Ing200086\Miner\HashInterface;
use Ing200086\Miner\Uint32;

class Unclaimed extends AbstractData
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

    protected static function generateHash(string $partialHash, HashInterface $nonce): string
    {
        $fullHash = hex2bin($partialHash . $nonce);

        $pass1Hash = hex2bin(hash('sha256', $fullHash));
        $pass2Hash = hash('sha256', $pass1Hash);

        return $pass2Hash;
    }

    public function testNonce(HashInterface $nonce)
    {
        $nonce = $nonce->endian(Uint32::LITTLE_ENDIAN);

        $shot = self::generateHash($this->partialHash, $nonce);
        $target = $this->data->target(); //->endian(Uint32::BIG_ENDIAN);

        var_dump($shot);
        var_dump(hexdec($shot));
        var_dump(hexdec($target));

        return hexdec($shot) < hexdec($target);
    }
}
