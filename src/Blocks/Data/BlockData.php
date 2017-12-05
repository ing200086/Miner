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

class BlockData implements BlockDataInterface
{
    use BlockDataTrait;

    public function __construct(
        HashInterface $version,
        HashInterface $previousBlockHash,
        HashInterface $merkleRoot,
        HashInterface $time,
        HashInterface $bits,
        HashInterface $target
    ) {
        $this->version = $version->endian()->little();
        $this->previousBlockHash = $previousBlockHash->endian()->little();
        $this->merkleRoot = $merkleRoot->endian()->little();
        $this->time = $time->endian()->little();
        $this->bits = $bits->endian()->little();
        $this->target = $target->endian()->little();
    }
}
