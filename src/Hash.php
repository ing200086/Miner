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

    protected function __construct($hexString)
    {
        $this->data = [];
        $this->appendHex($hexString);
    }

    public static function fromHex($hexString)
    {
        return new static($hexString);
    }

    protected function appendHex($hexString)
    {
        $chunks = self::splitHexStringByUint32BitChunks($hexString);

        foreach ($chunks as $bigEndianHexString) {
            $this->data[] = Uint32::fromHex($bigEndianHexString)->endian(Uint32::BIG_ENDIAN);
        }
    }

    public static function splitHexStringByUint32BitChunks($hexString)
    {
        preg_match_all('/......../', $hexString, $outputArray);
        return $outputArray[0];
    }

    public function toArray($endian = Uint32::BIG_ENDIAN)
    {
        $output = [];

        foreach ($this->data as $value) {
            $output[] = $value->endian($endian)->raw();
        }

        return $output;
    }
}
