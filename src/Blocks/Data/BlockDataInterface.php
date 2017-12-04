<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Blocks\Data;

use Ing200086\Miner\HashInterface;

interface BlockDataInterface
{
    public function previousBlockHash(): HashInterface;

    public function time(): HashInterface;

    public function version(): HashInterface;

    public function bits(): HashInterface;

    public function merkleRoot(): HashInterface;

    public function target(): HashInterface;

    public function nonce(): HashInterface;
}
