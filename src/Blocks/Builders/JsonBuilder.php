<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Blocks\Builders;

use Ing200086\Miner\Blocks\Data\BlockData;
use Ing200086\Miner\Enums\Endian;
use Ing200086\Miner\Hashes\Hash;

class JsonBuilder
{
    public static function fromJson($json)
    {
        $version = self::loadDec($json['version']);
        $time = self::loadDec($json['time']);

        $bits = self::loadHex($json['bits']);
        $target = self::uncompressTarget($bits);

        $previousBlockHash = self::loadHex($json['previousblockhash']);
        $merkleRoot = self::loadHex($json['merkleroot']);

        return new BlockData($version, $previousBlockHash, $merkleRoot, $time, $bits, $target);
    }

    protected static function loadHex($term)
    {
        return Hash::from()::hex($term, (new Endian(Endian::BIG)))
                    ->endian((new Endian(Endian::LITTLE)));
    }

    protected static function loadDec($term)
    {
        return Hash::from()::decimal($term, (new Endian(Endian::BIG)))
                    ->endian((new Endian(Endian::LITTLE)));
    }

    protected static function uncompressTarget($bits)
    {
        $bits = $bits->endian((new Endian(Endian::BIG)))->__toString();
        $threshold = hexdec(substr($bits, 0, 2));
        $mantissa = substr($bits, 2, 6);
        $target = str_pad($mantissa, 2 * $threshold, '0', STR_PAD_RIGHT);

        return self::loadHex($target);
    }
}
