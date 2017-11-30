<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class BlockData
{
    protected $version;
    protected $previousBlockHash;
    protected $merkleRoot;

    protected $time;
    protected $bits;
    protected $difficulty;

    protected $nonce;

    protected $partialHash;
    protected $blockHash;

    protected function __construct($version, $previousBlockHash, $time, $bits, $merkleRoot)
    {
        $this->version = Hash::fromDec($version, Uint32::BIG_ENDIAN)->endian(Uint32::LITTLE_ENDIAN);
        $this->time = Hash::fromDec($time, Uint32::BIG_ENDIAN)->endian(Uint32::LITTLE_ENDIAN);
        $this->bits = Hash::fromHex($bits, Uint32::BIG_ENDIAN)->endian(Uint32::LITTLE_ENDIAN);

        $this->previousBlockHash = Hash::fromHex($previousBlockHash, Uint32::BIG_ENDIAN)->endian(Uint32::LITTLE_ENDIAN);
        $this->merkleRoot = Hash::fromHex($merkleRoot, Uint32::BIG_ENDIAN)->endian(Uint32::LITTLE_ENDIAN);

        $this->partialHash = $this->version . $this->previousBlockHash . $this->merkleRoot .
                                $this->time . $this->bits;
    }

    public static function fromJson($json)
    {
        return new static(
            $json['version'],
            $json['previousblockhash'],
            $json['time'],
            $json['bits'],
            $json['merkleroot']
        );
    }

    public function previousBlockHash()
    {
        return $this->previousBlockHash;
    }

    public function time()
    {
        return $this->time;
    }

    public function version()
    {
        return $this->version;
    }

    public function bits()
    {
        return $this->bits;
    }

    public function merkleRoot()
    {
        return $this->merkleRoot;
    }

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

    public function target()
    {
        $bits = $this->bits()->endian(Uint32::BIG_ENDIAN)->__toString();
        $threshold = hexdec(substr($bits, 0, 2));
        $mantissa = substr($bits, 2, 6);
        $target = str_pad($mantissa, 2 * $threshold, '0', STR_PAD_RIGHT);

        return Hash::fromHex($target, Uint32::BIG_ENDIAN);
    }

    public function isValid()
    {
        $target = hexdec($this->target()->endian(Uint32::BIG_ENDIAN));
        $shot = hexdec($this->blockHash()->endian(Uint32::BIG_ENDIAN));
        return $shot < $target;
    }
}
