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
use Ing200086\Miner\Hashes\HashEndianSwapper;
use Ing200086\Miner\Hashes\HashInterface;
use PHPUnit\Framework\TestCase;

class HashEndianSwapperTest extends TestCase
{
    /**
     * @test
     */
    public function canSwapFromBigToLittleEndian()
    {
        $hash = $this->mockHash('000000020597ba1f');
        $endian = new Endian(Endian::BIG);

        $swapper = new HashEndianSwapper($hash, $endian);

        $this->assertEquals('1fba970502000000', $swapper->little());
    }

    /**
     * @test
     */
    public function canSwapFromLittleToBigEndian()
    {
        $hash = $this->mockHash('000000020597ba1f');
        $endian = new Endian(Endian::LITTLE);

        $swapper = new HashEndianSwapper($hash, $endian);

        $this->assertEquals('1fba970502000000', $swapper->big());
    }

    /**
     * @test
     */
    public function canKeepTheSameEndianAsInputLittle()
    {
        $hash = $this->mockHash('000000020597ba1f');
        $endian = new Endian(Endian::LITTLE);

        $swapper = new HashEndianSwapper($hash, $endian);

        $this->assertEquals('000000020597ba1f', $swapper->little());
    }

    /**
     * @test
     */
    public function canKeepTheSameEndianAsInputBig()
    {
        $hash = $this->mockHash('000000020597ba1f');
        $endian = new Endian(Endian::LITTLE);

        $swapper = new HashEndianSwapper($hash, $endian);

        $this->assertEquals('000000020597ba1f', $swapper->little());
    }

    protected function mockHash($returnString)
    {
        $hash = \Mockery::mock(HashInterface::class);
        $hash->shouldReceive('__toString')->once()->andReturn($returnString);

        return $hash;
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
}
