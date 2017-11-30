<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests;

class BlockExplorerData
{
    public static function oneTransaction()
    {
        return self::jsonDecodeFile('BlockExplorerData/OneTransaction.json');
    }

    public static function multipleTransactions()
    {
        return self::jsonDecodeFile('BlockExplorerData/MultipleTransaction.json');
    }

    public static function jsonDecodeFile($location)
    {
        $jsonString = file_get_contents($location, true);
        return json_decode($jsonString, true);
    }
}
