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

class HashEndianSwapper
{
    protected $creator;
    protected $hash;
    protected $endian;

    public function __construct(HashInterface $hash, $endian, HashCreator $creator = null)
    {
        $this->creator = $creator ?: new HashCreator();
        $this->hash = $hash;
        $this->endian = $endian;
    }

    public function little()
    {
        return $this->swap(new Endian(Endian::LITTLE));
    }

    public function big()
    {
        return $this->swap(new Endian(Endian::BIG));
    }

    protected function swap(Endian $destEndian)
    {
        if ($this->isInDestinationEndian($destEndian)) {
            return $this->hash;
        }

        return $this->creator::hex(self::swapEndianness($this->hash), $destEndian);
    }

    protected function isInDestinationEndian(Endian $destEndian): bool
    {
        return $this->endian == $destEndian;
    }

    protected static function swapEndianness(HashInterface $hex)
    {
        return implode(array_reverse(str_split($hex->__toString(), 2)));
    }
}
