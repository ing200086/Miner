<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\UnitTests\Blocks;

use Ing200086\Miner\Blocks\Data\BlockDataInterface;
use Ing200086\Miner\Blocks\Unclaimed as UnclaimedBlock;
use Ing200086\Miner\Hashes\HashInterface;
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class UnclaimedTest extends TestCase
{
    /**
     * @test
     */
    public function canTestNonceAgainstBlockDataSuccess()
    {
        $nonce = 10;

        $blockData = $this->createMockDataBlock(10, 10);

        $block = new UnclaimedBlock($blockData);

        $this->assertTrue($block->testNonce($nonce));
    }

    /**
     * @test
     */
    public function canTestNonceAgainstBlockDataFail()
    {
        $nonce = 10;

        $blockData = $this->createMockDataBlock(11, 10);

        $block = new UnclaimedBlock($blockData);

        $this->assertFalse($block->testNonce($nonce));
    }

    protected function createMockDataBlock($shot, $targetValue)
    {
        $partialHash = \Mockery::mock(HashInterface::class);
        $partialHash->shouldReceive('append->sha256->sha256')->andReturn($partialHash);
        $partialHash->shouldReceive('into->decimal')->andReturn($shot);

        $target = \Mockery::mock(HashInterface::class);
        $target->shouldReceive('into->decimal')->andReturn($targetValue);

        $blockData = \Mockery::mock(BlockDataInterface::class);
        $blockData->shouldReceive('partialHash')->andReturn($partialHash);
        $blockData->shouldReceive('target')->andReturn($target);

        return $blockData;
    }
}
