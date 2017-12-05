<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Primatives;

use Ing200086\Miner\Hashes\Hash;
use PHPUnit\Framework\TestCase;

/**
 * @group  Focus
 */
class HashCreatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider hexStringProvider
     */
    public function canCreateFromHexString($source)
    {
        $hash = Hash::from()::hex($source);

        $this->assertEquals($source, $hash);
    }

    /**
     * @test
     * @dataProvider decToHexProvider
     */
    public function canCreateFromDecimalString($source, $expected)
    {
        $hash = Hash::from()::decimal($source);

        $this->assertEquals($expected, $hash);
    }

    public function hexStringProvider()
    {
        return [
            ['000000020597ba1f'],
            ['ea67f49112505c9ffd17c459727118f05e69d8fb7799d860145a0ade22e2d182'],
            ['00000000000000000008b74e359dd486a77da426b7fc7ec0618c8033ed9e8482'],
            ['0000000000000000007c3160e3f097a33e51b0ebf3f60f03c732fdc1c5404c47'],
            ['1800d0f6'],
            ['000000000000000000000000000000000000000000f6d000'],
            ['1209d00e'],
        ];
    }

    public function decToHexProvider()
    {
        return [
            [248514834, '0ed00912'],
            [536870912, '20000000'],
            [1511817836, '5a1c826c'],
            [248514834, '0ed00912'],
        ];
    }
}
