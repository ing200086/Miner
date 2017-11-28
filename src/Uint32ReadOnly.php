<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class Uint32ReadOnly
{
    const TYPE_LENGTH = 32;

    const LITTLE_ENDIAN = 0;
    const BIG_ENDIAN = 1;

    protected $data;
    protected $endian;

    protected function __construct($data, $endian)
    {
        $this->data = $data;
        $this->endian = $endian;
    }

    public static function fromRaw($raw, $endian = self::BIG_ENDIAN)
    {
        return new static($raw, $endian);
    }

    public static function fromBin($bin, $endian = self::BIG_ENDIAN)
    {
        return new static(bindec($bin), $endian);
    }

    public static function fromHex($hex, $endian = self::BIG_ENDIAN)
    {
        return new static(hexdec($hex), $endian);
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

    public function getEndian()
    {
        return $this->endian;
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
