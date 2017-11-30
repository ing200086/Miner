<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class BlockData extends UnsolvedBlockData
{
    protected $nonce;

    protected $blockHash;

    public function setNonce($nonce)
    {
        $this->nonce = Hash::fromDec($nonce, Uint32::BIG_ENDIAN)->endian(Uint32::LITTLE_ENDIAN);
        $this->blockHash = null;

        return $this;
    }

    public function nonce()
    {
        return $this->nonce;
    }

    public function blockHash()
    {
        if (null == $this->blockHash) {
            $fullHash = $this->partialHash .
                        $this->nonce;

            $binaryHeader = hex2bin($fullHash);
            $pass1Hash = hash('sha256', $binaryHeader);
            $pass2Hash = hash('sha256', hex2bin($pass1Hash));
            $this->blockHash = Hash::fromHex($pass2Hash, Uint32::LITTLE_ENDIAN);
        }

        return $this->blockHash;
    }

    public function isValid()
    {
        $target = hexdec($this->target()->endian(Uint32::BIG_ENDIAN));
        $shot = hexdec($this->blockHash()->endian(Uint32::BIG_ENDIAN));
        return $shot < $target;
    }
}
