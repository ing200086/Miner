<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\BlockExplorerData;

class DataProvider
{
    public static function source()
    {
        $files = [
            'OneTransaction.json',
            'MultipleTransaction.json',
        ];

        return array_map(
            function ($file) {
                return getcwd() . '/' . $file;
            },
            $files
        );
    }

    public static function oneTransaction()
    {
        return self::jsonDecodeFile('OneTransaction.json');
    }

    public static function invalidTransactionWithSpecialTarget()
    {
        return self::jsonDecodeFile('InvalidTransactionWithSpecialTarget.json');
    }

    public static function multipleTransactions()
    {
        return self::jsonDecodeFile('MultipleTransaction.json');
    }

    public static function jsonDecodeFile($location)
    {
        $jsonString = file_get_contents($location, true);
        return json_decode($jsonString, true);
    }
}
