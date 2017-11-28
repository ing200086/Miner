<?php

namespace Ing200086\Miner\Tests;

class BlockExplorerData
{
    public static function oneTransaction()
    {
        return self::jsonDecodeFile("BlockExplorerData/OneTransaction.json");
    }

    public static function multipleTransactions()
    {
        return self::jsonDecodeFile("BlockExplorerData/multipleTransactions.json");
    }

    protected static function jsonDecodeFile($location)
    {
        $jsonString = file_get_contents($location, FILE_USE_INCLUDE_PATH);
        return json_decode($jsonString, true);
    }
}
