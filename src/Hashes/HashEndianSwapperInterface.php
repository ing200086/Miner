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

interface HashEndianSwapperInterface
{
    public function __construct(HashInterface $hash, $endian, HashCreatorInterface $creator = null);

    public function little() : HashInterface;

    public function big() : HashInterface;
}
