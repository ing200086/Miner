<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Blocks\Data;

use Ing200086\Miner\Uint32;
use Ing200086\Miner\Enums\Endian;
use Ing200086\Miner\HashInterface;

class BlockData implements BlockDataInterface
{
    protected $version;
    protected $previousBlockHash;
    protected $merkleRoot;

    protected $time;
    protected $bits;

    protected $target;

    protected $nonce;

    public function __construct(
        HashInterface $version,
        HashInterface $previousBlockHash,
        HashInterface $merkleRoot,
        HashInterface $time,
        HashInterface $bits,
        HashInterface $target,
        HashInterface $nonce = null
    ) {
        $this->version = $version->endian((new Endian(Endian::LITTLE)));
        $this->previousBlockHash = $previousBlockHash->endian((new Endian(Endian::LITTLE)));
        $this->merkleRoot = $merkleRoot->endian((new Endian(Endian::LITTLE)));
        $this->time = $time->endian((new Endian(Endian::LITTLE)));
        $this->bits = $bits->endian((new Endian(Endian::LITTLE)));
        $this->target = $target->endian((new Endian(Endian::LITTLE)));

        $this->nonce = $nonce ? $nonce->endian((new Endian(Endian::LITTLE))) : null;
    }

    public function previousBlockHash(): HashInterface
    {
        return $this->previousBlockHash;
    }

    public function time(): HashInterface
    {
        return $this->time;
    }

    public function version(): HashInterface
    {
        return $this->version;
    }

    public function bits(): HashInterface
    {
        return $this->bits;
    }

    public function merkleRoot(): HashInterface
    {
        return $this->merkleRoot;
    }

    public function target(): HashInterface
    {
        return $this->target;
    }

    public function nonce(): HashInterface
    {
        return $this->nonce;
    }
}
