<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Primatives;

use Ing200086\Miner\Enums\Endian;
use Ing200086\Miner\Hashes\Hash;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{
    /**
     * @test
     * @dataProvider hexStringEndianFlipProvider
     */
    public function canOutputHashFromBigEndianToLittleEndian($source, $expected)
    {
        $hash = Hash::from()::hex($source)->endian((new Endian(Endian::LITTLE)));

        $this->assertEquals($expected, $hash);
    }

    /**
     * @test
     * @dataProvider decToHexProvider
     */
    public function canIntepretDecToHexCorrectly($source, $expected)
    {
        $hash = Hash::from()::decimal($source)->endian((new Endian(Endian::BIG)));

        $this->assertEquals($expected, $hash);
    }

    /**
     * @test
     */
    public function canOutputBinary()
    {
        $source = '1800d0f6';
        $hash = Hash::from()::hex($source)->endian((new Endian(Endian::BIG)));
        $expected = '0001100000000000' . '1101000011110110';
        $actual = str_pad($hash->into()->binary(), 32, '0', STR_PAD_LEFT);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function canAppendTwoHashObjects()
    {
        $A = Hash::from()::hex('1800d0f6');
        $B = Hash::from()::hex('10101010');

        $C = $A->append($B);

        $this->assertEquals('1800d0f610101010', $C);
    }

    public function hexStringEndianFlipProvider()
    {
        return [
            ['000000020597ba1f', '1fba970502000000'],
            [
                'ea67f49112505c9ffd17c459727118f05e69d8fb7799d860145a0ade22e2d182',
                '82d1e222de0a5a1460d89977fbd8695ef018717259c417fd9f5c501291f467ea',
            ],
            [
                '00000000000000000008b74e359dd486a77da426b7fc7ec0618c8033ed9e8482',
                '82849eed33808c61c07efcb726a47da786d49d354eb708000000000000000000',
            ],
            [
                '0000000000000000007c3160e3f097a33e51b0ebf3f60f03c732fdc1c5404c47',
                '474c40c5c1fd32c7030ff6f3ebb0513ea397f0e360317c000000000000000000',
            ],
            ['1800d0f6', 'f6d00018'],
            ['000000000000000000000000000000000000000000f6d000', '00d0f6000000000000000000000000000000000000000000'],
            ['1209d00e', '0ed00912'],
        ];
    }

    public function decToHexProvider()
    {
        return [
            [248514834, '1209d00e'],
            [536870912, '00000020'],
            [1511817836, '6c821c5a'],
            [248514834, '1209d00e'],
        ];
    }
}
