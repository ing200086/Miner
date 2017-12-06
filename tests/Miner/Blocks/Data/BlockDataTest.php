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
use Ing200086\Miner\Hashes\HashInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class BlockDataTest extends TestCase
{
    protected $version;
    protected $previousBlockHash;
    protected $merkleRoot;
    protected $time;
    protected $bits;
    protected $target;
    protected $partialHash;

    protected $blockData;


    public function setUp()
    {
        $this->partialHash = $this->basicMockHash();
        $this->target = $this->basicMockHash();
        $this->bits = $this->basicMockHash();
        $this->time = $this->basicMockHash($this->bits, $this->partialHash);
        $this->merkleRoot = $this->basicMockHash($this->time, $this->time);
        $this->previousBlockHash = $this->basicMockHash($this->merkleRoot, $this->merkleRoot);
        $this->version = $this->basicMockHash($this->previousBlockHash, $this->previousBlockHash);

        $this->blockData = new BlockData(
            $this->version,
            $this->previousBlockHash,
            $this->merkleRoot,
            $this->time,
            $this->bits,
            $this->target
        );
    }

    /**
     * @test
     */
    public function canLoadHashedVersion()
    {
        $this->assertEquals($this->version, $this->blockData->version());
    }

    /**
     * @test
     */
    public function canLoadHashedTime()
    {
        $this->assertEquals($this->time, $this->blockData->time());
    }

    /**
     * @test
     */
    public function canLoadPreviousBlockHash()
    {
        $this->assertEquals($this->previousBlockHash, $this->blockData->previousBlockHash());
    }

    /**
     * @test
     */
    public function canLoadMerkleRoot()
    {
        $this->assertEquals($this->merkleRoot, $this->blockData->merkleRoot());
    }

    /**
     * @test
     */
    public function canLoadHashedBits()
    {
        $this->assertEquals($this->bits, $this->blockData->bits());
    }

    /**
     * @test
     */
    public function canReturnTarget()
    {
        $this->assertEquals($this->target, $this->blockData->target());
    }

    /**
     * @test
     */
    public function canReturnPartialHash()
    {
        $this->assertEquals($this->partialHash, $this->blockData->partialHash());
    }

    protected function basicMockHash($appendArgument = null, $appendTarget = null)
    {
        $hash = Mockery::mock(HashInterface::class);
        $hash->shouldReceive('endian->little')->andReturn($hash);

        if ($appendArgument != null) {
            $hash->shouldReceive('append')->with($appendArgument)->andReturn($appendTarget);
        }

        return $hash;
    }
}
