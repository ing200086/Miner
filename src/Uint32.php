<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class Uint32 extends Uint32ReadOnly
{
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

    public function orMerge(self $term)
    {
        return self::fromRaw($this->data | $term->data);
    }

    public function byteReversal()
    {
        $this->endian = self::oppositeEndian($this->endian);

        $result = $this->shiftLeft(24)->mask(self::fromHex('FF000000'))
                    ->orMerge($this->shiftLeft(8)->mask(self::fromHex('00FF0000')))
                    ->orMerge($this->shiftRight(8)->mask(self::fromHex('0000FF00')))
                    ->orMerge($this->shiftRight(24)->mask(self::fromHex('000000FF')));

        return $result;
    }

    protected static function oppositeEndian($current)
    {
        return ($current == self::BIG_ENDIAN) ? self::LITTLE_ENDIAN : self::BIG_ENDIAN;
    }

    public function endian($endian)
    {
        if ($this->endian != $endian) {
            return self::fromRaw($this->byteReversal()->raw(), $endian);
        }

        return $this;
    }
}
