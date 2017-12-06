<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Hashes;

interface HashFormatterInterface
{
    public function load(HashInterface $data): self;

    public function hex();

    public function hexSubstr(int $start = 0, int $end = 0, int $padRight = 0);

    public function decimal();

    public function decimalSubstr(int $start = 0, int $end = 0);

    public function binary();
}
