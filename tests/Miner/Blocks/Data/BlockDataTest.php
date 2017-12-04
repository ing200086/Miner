<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Blocks;

use Ing200086\Miner\Blocks\Data\BlockData;
use Ing200086\Miner\Hash;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class BlockDataTest extends TestCase
{
    /**
     * @test
     */
    public function canLoadHashedVersion()
    {
        $hash = Mockery::mock(Hash::class);
        $hash->shouldReceive('endian')->andReturnSelf();

        $blockData = new BlockData($hash, $hash, $hash, $hash, $hash, $hash);


        $this->assertEquals($hash, $blockData->version());
    }

    /**
     * @test
     */
    public function canLoadHashedTime()
    {
        $hash = Mockery::mock(Hash::class);
        $hash->shouldReceive('endian')->andReturnSelf();

        $blockData = new BlockData($hash, $hash, $hash, $hash, $hash, $hash);


        $this->assertEquals($hash, $blockData->time());
    }

    /**
     * @test
     */
    public function canLoadPreviousBlockHash()
    {
        $hash = Mockery::mock(Hash::class);
        $hash->shouldReceive('endian')->andReturnSelf();

        $blockData = new BlockData($hash, $hash, $hash, $hash, $hash, $hash);


        $this->assertEquals($hash, $blockData->previousBlockHash());
    }

    /**
     * @test
     */
    public function canLoadMerkleRoot()
    {
        $hash = Mockery::mock(Hash::class);
        $hash->shouldReceive('endian')->andReturnSelf();

        $blockData = new BlockData($hash, $hash, $hash, $hash, $hash, $hash);


        $this->assertEquals($hash, $blockData->merkleRoot());
    }

    /**
     * @test
     */
    public function canLoadHashedBits()
    {
        $hash = Mockery::mock(Hash::class);
        $hash->shouldReceive('endian')->andReturnSelf();

        $blockData = new BlockData($hash, $hash, $hash, $hash, $hash, $hash);

        $this->assertEquals($hash, $blockData->bits());
    }

    /**
     * @test
     */
    public function canGenerateTarget()
    {
        $hash = Mockery::mock(Hash::class);
        $hash->shouldReceive('endian')->andReturnSelf();

        $blockData = new BlockData($hash, $hash, $hash, $hash, $hash, $hash);

        $this->assertEquals($hash, $blockData->target());
    }
}
