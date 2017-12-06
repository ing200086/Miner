<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Blocks\Builders;

use Ing200086\Miner\Blocks\Data\BlockDataInterface;

interface BlockDataBuilderInterface
{
    public function load($data): void;

    public function build() : BlockDataInterface;
}
