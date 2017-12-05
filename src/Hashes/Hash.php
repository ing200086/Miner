<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Hashes;

use Ing200086\Miner\Enums\Endian;

class Hash implements HashInterface
{
    protected $data;
    protected $endian;

    public function __construct($hexString, $endian)
    {
        $this->data = $hexString;
        $this->endian = $endian;
    }

    public static function from(): HashCreator
    {
        return new HashCreator();
    }

    public function __toString()
    {
        return $this->data;
    }

    public function endian()
    {
        $swap = new HashEndianSwapper($this, $this->endian);

        return $swap;
    }

    public function append(HashInterface $tail): HashInterface
    {
        return self::from()::hex($this->data . $tail, $this->endian);
    }

    public function into(HashFormatter $formatter = null): HashFormatter
    {
        $formatter = ($formatter) ?: (new HashFormatter());
        $formatter->load($this);

        return $formatter;
    }

    protected function swapEndianness($hex)
    {
        return implode(array_reverse(str_split($hex, 2)));
    }
}
