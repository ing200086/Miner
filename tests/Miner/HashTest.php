<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests;

use Ing200086\Miner\Hash;
use Ing200086\Miner\Uint32;
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class HashTest extends TestCase
{
    /**
     * @test
     */
    public function canOutputHashFromBigEndianToLittleEndian()
    {
        $source = '00000002' . '0597ba1f';
        $hash = Hash::fromHex($source)->endian(Uint32::LITTLE_ENDIAN);
        $expected = '1fba9705' . '02000000';

        $this->assertEquals($expected, $hash);
    }

    /**
     * @test
     */
    public function canIntepretDecToHexCorrectly()
    {
        $source = 248514834;
        $hash = Hash::fromDec($source)->endian(Uint32::BIG_ENDIAN);
        $expected = '1209d00e';

        $this->assertEquals($expected, $hash);
    }

    /**
     * @test
     * @group Focus
     */
    public function canOutputBinary()
    {
        $source = '1800d0f6';
        $hash = Hash::fromHex($source)->endian(Uint32::BIG_ENDIAN);
        $expected = '0001100000000000' . '1101000011110110';
        $actual = str_pad(decbin(hexdec($hash->__toString())), 32, '0', STR_PAD_LEFT);

        $this->assertEquals($expected, $actual);
    }
}
