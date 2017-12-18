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
use Ing200086\Miner\Enums\Endian;
use Ing200086\Miner\Hashes\HashCreator;
use Ing200086\Miner\Hashes\HashCreatorInterface;

class Unclaimed implements UnclaimedInterface
{
    protected $hashCreator;
    protected $data;

    public function __construct(BlockDataInterface $data, HashCreatorInterface $hashCreator = null)
    {
        $this->data = $data;
        $this->hashCreator = $hashCreator ?: (new HashCreator());
    }

    public function testNonce(int $nonce)
    {
        $shot = $this->result($nonce);

        return $shot->endian()->big()->into()->decimal() <= $this->data->target()->endian()->big()->into()->decimal();
    }

    public function result(int $nonce, bool $doubleHash = true)
    {
        $nonce = $this->hashCreator::decimal($nonce, new Endian(Endian::BIG))->endian()->little();
        $shot = $this->data->partialHash()->append($nonce);

        return ($doubleHash) ? $shot->sha256()->sha256() : $shot;
    }
}
