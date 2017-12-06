<?php

namespace Ing200086\Miner\Tests\UnitTests\Miners;

use PHPUnit\Framework\TestCase;
use Ing200086\Miner\Blocks\Unclaimed;
use Ing200086\Miner\Miners\ArithmaticalMiner;
use Ing200086\Miner\Blocks\UnclaimedInterface;

class ArithmaticalMinerTest extends TestCase
{
    /**
     * @test
     */
    public function canMakeMinerWithIncrement()
    {
        $miner = new ArithmaticalMiner(3);

        $this->assertInstanceOf(ArithmaticalMiner::class, $miner);
    }

    /**
     * @test
     */
    public function canLoadAnUnclaimedBlock()
    {
        $unclaimed = \Mockery::mock(UnclaimedInterface::class);
        $miner = new ArithmaticalMiner(1);
        $miner->load($unclaimed);

        $this->assertEquals($unclaimed, $miner->nugget());
    }

    /**
     * @test
     */
    public function canMine()
    {
        $unclaimed = \Mockery::mock(UnclaimedInterface::class);
        $unclaimed->shouldReceive('testNonce')->andReturn(true);

        $nonce = 1;
        $miner = new ArithmaticalMiner(1);

        $miner->load($unclaimed);
        $miner->seed($nonce);
        $miner->run();

        $this->assertEquals($nonce, $miner->key());
    }
}
