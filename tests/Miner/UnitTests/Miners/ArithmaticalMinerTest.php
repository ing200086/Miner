<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\UnitTests\Miners;

use Ing200086\Miner\Blocks\UnclaimedInterface;
use Ing200086\Miner\Miners\ArithmaticalMiner;
use Ing200086\Miner\Miners\Patterns\ArithmaticalPattern;
use PHPUnit\Framework\TestCase;

class ArithmaticalMinerTest extends TestCase
{
    /**
     * @test
     */
    public function canMakeMinerWithPattern()
    {
        $pattern = \Mockery::mock(ArithmaticalPattern::class);
        $miner = new ArithmaticalMiner($pattern);

        $this->assertInstanceOf(ArithmaticalMiner::class, $miner);
    }

    /**
     * @test
     */
    public function canLoadAnUnclaimedBlock()
    {
        $unclaimed = \Mockery::mock(UnclaimedInterface::class);
        $pattern = \Mockery::mock(ArithmaticalPattern::class);
        $miner = new ArithmaticalMiner($pattern);
        $miner->load($unclaimed);

        $this->assertEquals($unclaimed, $miner->nugget());
    }

    /**
     * @test
     */
    public function canGetCyclesRequiredToFindKey()
    {
        $valid = 1;
        $cycles = 11;
        $pattern = $this->makePattern($valid, $cycles);
        $unclaimed = $this->makeBlock($valid);

        $miner = new ArithmaticalMiner($pattern);
        $miner->load($unclaimed)->run();

        $this->assertEquals($cycles, $miner->cycles());
    }

    /**
     * @test
     */
    public function canGetFoundNonce()
    {
        $valid = 1;
        $cycles = 11;
        $pattern = $this->makePattern($valid, $cycles);
        $unclaimed = $this->makeBlock($valid);

        $miner = new ArithmaticalMiner($pattern);
        $miner->load($unclaimed)->run();

        $this->assertEquals($valid, $miner->key());
    }

    /**
     * @test
     */
    public function canReachMaxCyclesWithNoKey()
    {
        $valid = 1;
        $cycles = 11;
        $pattern = $this->makePattern($valid, $cycles);
        $unclaimed = $this->makeBlock($valid);

        $miner = new ArithmaticalMiner($pattern);
        $miner->load($unclaimed)->maxCycles($cycles - 1)->run();

        $this->assertEquals($cycles - 1, $miner->cycles());
        $this->assertNull($miner->key());
    }

    protected function makePattern($valid, $cycles, $invalid = null)
    {
        $invalid = $invalid ?: $valid + 1;
        $pattern = \Mockery::mock(ArithmaticalPattern::class);
        $pattern->shouldReceive('current')->times($cycles)->andReturn($invalid)
                    ->shouldReceive('next')->times($cycles)
                    ->shouldReceive('current')->andReturn($valid);

        return $pattern;
    }

    protected function makeBlock($valid)
    {
        $unclaimed = \Mockery::mock(UnclaimedInterface::class);
        $unclaimed->shouldReceive('testNonce')->with(\Mockery::not($valid))->andReturn(false)
                    ->shouldReceive('testNonce')->with($valid)->andReturn(true);

        return $unclaimed;
    }
}
