<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Hashes;

interface HashInterface
{
    public static function from(): HashCreator;

    public function endian($endian): self;

    public function into(): HashFormatter;

    // public function append(HashInterface $tail) : HashInterface;
}
