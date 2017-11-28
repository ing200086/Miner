<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class Uint32
{
    const TYPE_LENGTH = 32;

    protected $data;

    protected function __construct($data)
    {
        $this->data = $data;
    }

    public static function fromRaw($raw)
    {
        return new static($raw);
    }

    public static function fromBin($bin)
    {
        return new static(bindec($bin));
    }

    public static function fromHex($hex)
    {
        return new static(hexdec($hex));
    }

    public function shiftLeft($shifts)
    {
        if ($shifts > 0) {
            $shifted = $this->data << $shifts;
            return self::fromBin(self::truncate(decbin($shifted)));
        }

        return $this;
    }

    public function shiftRight($shifts)
    {
        if ($shifts > 0) {
            $shifted = $this->data >> $shifts;
            return self::fromBin(self::truncate(decbin($shifted), $shifts));
        }

        return $this;
    }

    public function mask(self $mask)
    {
        return self::fromRaw($this->data & $mask->data);
    }

    public function or(self $term)
    {
        return self::fromRaw($this->data | $term->data);
    }

    public function byteReversal()
    {
        $result = $this->shiftLeft(24)->mask(self::fromHex('FF000000'))
                  ->or($this->shiftLeft(8)->mask(self::fromHex('00FF0000')))
                  ->or($this->shiftRight(8)->mask(self::fromHex('0000FF00')))
                  ->or($this->shiftRight(24)->mask(self::fromHex('000000FF')));

        return $result;
    }

    public function raw()
    {
        return $this->data;
    }

    public function bin()
    {
        return self::binValueToLength(decbin($this->raw()));
    }

    public function hex()
    {
        $hexNoPad = dechex($this->data);
        return str_pad($hexNoPad, 8, '0', STR_PAD_LEFT);
    }

    protected static function binValueToLength($original)
    {
        return self::truncate(self::pad($original));
    }

    protected static function pad($original)
    {
        return str_pad($original, self::TYPE_LENGTH, '0', STR_PAD_LEFT);
    }

    protected static function truncate($original, $offset = 0)
    {
        return substr($original, -self::TYPE_LENGTH + $offset);
    }
}
