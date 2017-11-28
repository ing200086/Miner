<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests;

use Ing200086\Miner\Uint32;
use PHPUnit\Framework\TestCase;

class Uint32Test extends TestCase
{
    /**
     * @test
     */
    public function canCreateFromHexCode()
    {
        $hex = 'FFFFFFFF';
        $expected = Uint32::fromBin('11111111' . '11111111' . '11111111' . '11111111');

        $this->assert32BitEquals($expected, Uint32::fromHex($hex));
    }

    /**
     * @test
     * @dataProvider rightShiftProvider
     */
    public function canShiftRightUint32($original, $bitShifts, $expected)
    {
        $original = Uint32::fromRaw($original);
        $expected = Uint32::fromRaw($expected);

        $this->assert32BitEquals($expected, $original->shiftRight($bitShifts));
    }

    /**
     * @test
     * @dataProvider leftShiftProvider
     */
    public function canLeftShiftUint32($original, $bitShifts, $expected)
    {
        $original = Uint32::fromRaw($original);
        $expected = Uint32::fromRaw($expected);

        $this->assert32BitEquals($expected, $original->shiftLeft($bitShifts));
    }

    /**
     * @test
     */
    public function canOutputBinaryString()
    {
        $original = '0000' . '0000' . '1010' . '1010'
                  . '1100' . '1100' . '1111' . '1111';

        $actual = Uint32::fromBin($original)->bin();

        $this->assertEquals($original, $actual);
    }

    /**
     * @test
     */
    public function canOutputHexString()
    {
        $original = 'fefefefe';

        $actual = Uint32::fromHex($original)->hex();

        $this->assertEquals($original, $actual);
    }

    /**
     * @test
     * @dataProvider poolDataProvider
     */
    public function canGenerateFinalUint32FromPoolHexStringSegment($hex, $dec)
    {
        $actual = Uint32::fromHex($hex);
        $expected = Uint32::fromRaw($dec);

        $this->assert32BitEquals($expected, $actual->byteReversal());
    }

    /**
     * @test
     * @dataProvider poolDataProvider
     */
    public function canGeneratePoolHexStringSegmentsFromUint32($hex, $dec)
    {
        $actual = Uint32::fromRaw($dec);
        $expected = Uint32::fromHex($hex);

        $this->assert32BitEquals($expected, $actual->byteReversal());
    }

    public function poolDataProvider()
    {
        return [
            ['36caf078', 2029046326],
            ['fcf348d1', -783748100],
            ['b56f301f', 523268021],
            ['1e6cc1d5', -708744162],
            ['8d00bf85', -2051080051],
            ['cb25f304', 83043787],
            ['ac24af2e', 783230124],
            ['b1935bc8', -933522511],
        ];
    }

    /**
     * @test
     * @dataProvider hexEndianProviderBigLittle
     */
    public function bigEndianToLittleEndianHexString($bigEndian, $littleEndian)
    {
        $actual = Uint32::fromHex($bigEndian)->byteReversal();

        $this->assertEquals($littleEndian, $actual->hex());
    }

    public function hexEndianProviderBigLittle()
    {
        return [
            ['0597ba1f', '1fba9705'],
            ['00000002', '02000000'],
        ];
    }

    /**
     * @test
     */
    public function canBeMaskedByAnotherUint32()
    {
        $original = Uint32::fromRaw(511);
        $mask = Uint32::fromRaw(510);
        $expected = Uint32::fromRaw(510);

        $this->assert32BitEquals($expected, $original->mask($mask));
    }

    /**
     * @test
     * @dataProvider byteReversalProvider
     */
    public function canPerformByteReversal($original, $expected)
    {
        $original = Uint32::fromRaw($original);
        $expected = Uint32::fromRaw($expected);

        $this->assert32BitEquals($expected, $original->byteReversal());
    }

    public function byteReversalProvider()
    {
        return [
            [bindec('0000' . '0000' . '1010' . '1010'
                  . '1100' . '1100' . '1111' . '1111'),
             bindec('1111' . '1111' . '1100' . '1100'
                  . '1010' . '1010' . '0000' . '0000'), ],
        ];
    }

    public function rightShiftProvider()
    {
        return [
            [bindec('0000' . '0000' . '1010' . '1010'
                  . '1100' . '1100' . '1111' . '1111'), 4, bindec('0000' . '0000' . '0000' . '1010'
                   . '1010' . '1100' . '1100' . '1111')],
             [-9, 2, 1073741821],
        ];
    }

    public function leftShiftProvider()
    {
        return [
            [bindec('0000' . '0000' . '1010' . '1010'
                  . '1100' . '1100' . '1111' . '1111'), 12, bindec('1010' . '1100' . '1100' . '1111'
                   . '1111' . '0000' . '0000' . '0000')],
             [-51164975, 24, -788529152],
            [51164975, 24, 788529152],
        ];
    }

    protected function assert32BitEquals(Uint32 $expected, Uint32 $actual)
    {
        $this->assertEquals($expected->bin(), $actual->bin());
    }
}
