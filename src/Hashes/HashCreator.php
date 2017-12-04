<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Hashes;

use Ing200086\Miner\Enums\Endian;

class HashCreator
{
    public static function hex($hex, Endian $endian = null)
    {
        $endian = ($endian) ?: (new Endian(Endian::BIG));
        return new Hash($hex, $endian);
    }

    public static function decimal($dec, Endian $endian = null)
    {
        $endian = ($endian) ?: (new Endian(Endian::LITTLE));
        $hex = str_pad(dechex($dec), 8, '0', STR_PAD_LEFT);
        return new Hash($hex, $endian);
    }
}
