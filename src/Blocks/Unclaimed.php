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

class Unclaimed implements UnclaimedInterface
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
    }

    public function testNonce(HashInterface $nonce)
    {
        $shot = $this->data->partialHash()->append($nonce->endian()->little())->sha256()->sha256();

        return $shot->into()->decimal() <= $this->data->target()->into()->decimal();
    }
}
