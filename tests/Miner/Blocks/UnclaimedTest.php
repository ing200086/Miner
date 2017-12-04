<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Blocks;

use Ing200086\Miner\Blocks\Data\BlockDataInterface;
use Ing200086\Miner\Blocks\Unclaimed as UnclaimedBlock;
use Ing200086\Miner\HashInterface;
use Ing200086\Miner\Tests\BlockExplorerData\DataProvider;
use Ing200086\Miner\Uint32;
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class UnclaimedTest extends TestCase
{
    /**
     * @test
     * @group  Focus
     */
    public function canTestNonceAgainstBlockData()
    {
        $this->markTestIncomplete('refactoring');
        $nonce = \Mockery::mock(HashInterface::class);
        $nonce->shouldReceive('endian')->andReturnSelf();
        $nonce->shouldReceive('__toString')->andReturn('1209d00e');

        $blockData = $this->createMockDataBlock();

        $block = new UnclaimedBlock($blockData);

        $this->assertTrue($block->testNonce($nonce));
    }

    /**
     * @test
     */
    public function canGenerateTarget()
    {
        $this->markTestIncomplete('refactoring');
        $jsonData = DataProvider::oneTransaction();
        $block = UnclaimedBlock::fromJson($jsonData);

        $target = $block->target()->endian(Uint32::LITTLE_ENDIAN);

        $this->assertEquals('000000000000000000000000000000000000000000f6d000', $target);
    }

    protected function littleEndian($value)
    {
        return implode((unpack('H*', pack('V*', $value))));
    }

    public function jsonProvider()
    {
        return DataProvider::source();
    }

    protected function createMockDataBlock()
    {
        $blockData = \Mockery::mock(BlockDataInterface::class);

        $this->addHashReturn($blockData, 'version', '00000020');
        $this->addHashReturn($blockData, 'time', '6c821c5a');

        $this->addHashReturn(
            $blockData,
            'previousBlockHash',
            '82849eed33808c61c07efcb726a47da786d49d354eb708000000000000000000'
        );
        $this->addHashReturn(
            $blockData,
            'merkleRoot',
            '82d1e222de0a5a1460d89977fbd8695ef018717259c417fd9f5c501291f467ea'
        );
        $this->addHashReturn($blockData, 'bits', 'f6d00018');
        $this->addHashReturn($blockData, 'target', '00d0f6000000000000000000000000000000000000000000');

        return $blockData;
    }

    protected function addHashReturn($data, $key, $returnString)
    {
        $hash = $this->createHashWithStringReturn($returnString);
        $data->shouldReceive($key)->andReturn($hash);

        return $data;
    }

    protected function createHashWithStringReturn($returnValue)
    {
        $hash = \Mockery::mock(HashInterface::class);
        $hash->shouldReceive('__toString')->andReturn($returnValue);

        return $hash;
    }
}
