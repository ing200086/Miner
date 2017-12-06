<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Blocks\Builders;

use Ing200086\Miner\Enums\Endian;
use Ing200086\Miner\Hashes\HashCreator;
use Ing200086\Miner\Hashes\HashInterface;
use Ing200086\Miner\Blocks\Data\BlockData;
use Ing200086\Miner\Blocks\Data\BlockDataTrait;
use Ing200086\Miner\Blocks\Data\BlockDataInterface;

abstract class AbstractBlockDataBuilder implements BlockDataBuilderInterface
{
    protected $hashCreator;

    use BlockDataTrait;

    public function __construct()
    {
        $this->hashCreator = new HashCreator();
    }

    abstract public function load($data): void;

    public function build() : BlockDataInterface
    {
        return new BlockData(
            $this->version,
            $this->previousBlockHash,
            $this->merkleRoot,
            $this->time,
            $this->bits,
            $this->target
        );
    }

    protected function loadHex($term): HashInterface
    {
        return $this->hashCreator::hex($term)->endian()->little();
    }

    protected function loadDec($term): HashInterface
    {
        return $this->hashCreator::decimal($term, (new Endian(Endian::BIG)))->endian()->little();
    }
}
