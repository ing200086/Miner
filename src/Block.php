<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner;

class Block
{
    protected $littleEndianData;

    protected function __construct()
    {
        $this->littleEndianData = [];
    }

    public static function create()
    {
        return new static();
    }

    public function loadFromPoolString($poolString)
    {
        $chunks = self::splitHexStringByUint32BitChunks($poolString)[0];

        foreach ($chunks as $bigEndianHexString) {
            $this->littleEndianData[] = Uint32::fromHex($bigEndianHexString)->byteReversal();
        }
    }

    public static function splitHexStringByUint32BitChunks($hexString)
    {
        preg_match_all('/......../', $hexString, $output_array);
        return $output_array;
    }

    public function littleEndianString()
    {
        $outputString = '';

        foreach ($this->littleEndianData as $value) {
            $outputString = $outputString . $value->hex();
        }

        return $outputString;
    }
}
