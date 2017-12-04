<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Blocks\Builders;

use Ing200086\Miner\Blocks\Unclaimed;
use Ing200086\Miner\Hash;
use Ing200086\Miner\Uint32;

class JsonBuilder
{
    public static function fromJson($json)
    {
        $json = 0;
        // $version = self::loadDec($json['version']);
        // $time = self::loadDec($json['time']);

        // $bits = self::loadHex($json['bits']);
        // $target = self::uncompressTarget($bits);

        // $previousBlockHash = self::loadHex($json['previousblockhash']);
        // $merkleRoot = self::loadHex($json['merkleroot']);

        // return new Unclaimed($version, $previousBlockHash, $time, $bits, $merkleRoot, $target);
    }

    protected static function loadHex($term)
    {
        return Hash::fromHex($term, Uint32::BIG_ENDIAN)->endian(Uint32::LITTLE_ENDIAN);
    }

    protected static function loadDec($term)
    {
        return Hash::fromDec($term, Uint32::BIG_ENDIAN)->endian(Uint32::LITTLE_ENDIAN);
    }

    protected static function uncompressTarget($bits)
    {
        $bits = $bits->endian(Uint32::BIG_ENDIAN)->__toString();
        $threshold = hexdec(substr($bits, 0, 2));
        $mantissa = substr($bits, 2, 6);
        $target = str_pad($mantissa, 2 * $threshold, '0', STR_PAD_RIGHT);

        return self::loadHex($target);
    }
}
