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

interface HashCreatorInterface
{
    public static function hex($hex, Endian $endian = null): HashInterface;

    public static function decimal($dec, Endian $endian = null): HashInterface;
}
