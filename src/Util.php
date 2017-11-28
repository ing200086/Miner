<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class Util
{
    public static function uint32ArrayToHex($arr)
    {
        // PHP 5.3+
        return implode('', array_map(function ($a) {
            return str_pad(dechex($a), 8, '0', STR_PAD_LEFT);
        }, $arr));
        // PHP 5.2
        // $s = '';
        // foreach ($arr as $a) {
        //     $s .= str_pad(substr(dechex($a), -8), 8, '0', STR_PAD_LEFT);
        // }
        // return $s;
    }

    public static function hexToUint32Array($hex)
    {
        return array_map('hexdec', str_split($hex, 8));
    }

    public static function reverseBytesInWord($w)
    {
        $a = self::applyHexMask(self::uint32LeftShift($w, 24), 0xff000000)
                | self::applyHexMask(self::uint32LeftShift($w, 8), 0x00ff0000)
                | self::applyHexMask(self::zeroFill($w, 8), 0x0000ff00)
                | self::applyHexMask(self::zeroFill($w, 24), 0x000000ff);

        // 64bits
        if (hexdec(80000000) & $a) {
            $a = ~$a ^ 0xffffffff;
        }
        return $a;
    }

    public static function reverseBytesInWords($words)
    {
        $reversed = [];
        foreach ($words as $word) {
            $reversed[] = self::reverseBytesInWord($word);
        }
        return $reversed;
    }

    public static function fromPoolString($hex)
    {
        $hexGroups = self::hexToUint32Array($hex);
        return self::reverseBytesInWords($hexGroups);
    }

    public static function toPoolString($data)
    {
        return self::uint32ArrayToHex(self::reverseBytesInWords($data));
    }
}
