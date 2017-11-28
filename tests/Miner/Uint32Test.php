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
        $actual = Uint32::fromHex($hex);

        $this->assert32BitEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function canKeepTrackOfEndian()
    {
        $original = Uint32::fromHex('FFFFFFFF');

        $this->assertEquals(Uint32::BIG_ENDIAN, $original->getEndian());
        $this->assertNotEquals(Uint32::LITTLE_ENDIAN, $original->getEndian());

        $littleEndian = $original->endian(Uint32::LITTLE_ENDIAN);

        $this->assertEquals(Uint32::LITTLE_ENDIAN, $littleEndian->getEndian());
        $this->assertNotEquals(Uint32::BIG_ENDIAN, $littleEndian->getEndian());

        $bigEndian = $original->endian(Uint32::BIG_ENDIAN);

        $this->assertEquals(Uint32::BIG_ENDIAN, $bigEndian->getEndian());
        $this->assertNotEquals(Uint32::LITTLE_ENDIAN, $bigEndian->getEndian());
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

    /**
     * @test
     * @dataProvider endianFlipProvider
     */
    public function bigEndianToLittleEndianHexString($src, $dest, $srcEndian, $destEndian)
    {
        $actual = Uint32::fromHex($src, $srcEndian)->endian($destEndian);

        $this->assertEquals($dest, $actual->hex());
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

    public function endianFlipProvider()
    {
        return [
            ['0597ba1f', '1fba9705', Uint32::BIG_ENDIAN, Uint32::LITTLE_ENDIAN],
            ['00000002', '02000000', Uint32::BIG_ENDIAN, Uint32::LITTLE_ENDIAN],
            ['0597ba1f', '1fba9705', Uint32::LITTLE_ENDIAN, Uint32::BIG_ENDIAN],
            ['00000002', '02000000', Uint32::LITTLE_ENDIAN, Uint32::BIG_ENDIAN],
            ['0597ba1f', '0597ba1f', Uint32::BIG_ENDIAN, Uint32::BIG_ENDIAN],
            ['00000002', '00000002', Uint32::BIG_ENDIAN, Uint32::BIG_ENDIAN],
            ['0597ba1f', '0597ba1f', Uint32::LITTLE_ENDIAN, Uint32::LITTLE_ENDIAN],
            ['00000002', '00000002', Uint32::LITTLE_ENDIAN, Uint32::LITTLE_ENDIAN],
        ];
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
