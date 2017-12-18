<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Blocks\Builders;

use Ing200086\Miner\Hashes\HashInterface;

class JsonBuilder extends AbstractBlockDataBuilder implements BlockDataBuilderInterface
{
    public function __construct($data)
    {
        parent::__construct();
        $this->load($data);
    }

    public function load($data): void
    {
        $this->version = self::loadDec($data['version']);
        $this->time = self::loadDec($data['time']);

        $this->bits = self::loadHex($data['bits']);

        $this->previousBlockHash = self::loadHex($data['previousblockhash']);
        $this->merkleRoot = self::loadHex($data['merkleroot']);

        $this->target = self::uncompressTarget($this->bits->endian()->big());
    }

    protected function uncompressTarget(HashInterface $bits): HashInterface
    {
        $padLength = 2 * $bits->into()->decimalSubstr(0, 2);
        $target = $bits->into()->hexSubstr(2, 8, $padLength);

        return $this->loadHex($target);
    }
}
