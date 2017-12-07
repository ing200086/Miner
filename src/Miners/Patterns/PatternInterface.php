<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Miners\Patterns;

interface PatternInterface
{
    public function next(): void;

    public function current(): int;
}
