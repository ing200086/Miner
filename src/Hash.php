<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class Hash
{
    protected $data;
    protected $endian;

    protected function __construct($hexString, $endian)
    {
        $this->data = $hexString;
        $this->endian = $endian;
    }

    public static function fromHex($hex, $endian = Uint32::BIG_ENDIAN)
    {
        return new static($hex, $endian);
    }

    public static function fromDec($dec, $endian = Uint32::LITTLE_ENDIAN)
    {
        $hex = str_pad(dechex($dec), 8, '0', STR_PAD_LEFT);
        return self::fromHex($hex, $endian);
    }

    public function __toString()
    {
        return $this->data;
    }

    public function endian($endian)
    {
        if ($this->endian != $endian) {
            return self::fromHex($this->swapEndianness($this->data), $endian);
        }

        return $this;
    }

    protected function swapEndianness($hex)
    {
        return implode(array_reverse(str_split($hex, 2)));
    }
}
