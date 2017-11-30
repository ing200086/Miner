<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests;

use Ing200086\Miner\BlockData;
use Ing200086\Miner\Uint32;
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
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData);

        $this->assertEquals(
            $this->littleEndian($jsonData['version']),
            $block->version()->endian(Uint32::LITTLE_ENDIAN)
        );
    }

    /**
     * @test
     */
    public function canLoadHashedTime()
    {
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData);

        $this->assertEquals($this->littleEndian($jsonData['time']), $block->time()->endian(Uint32::LITTLE_ENDIAN));
    }

    /**
     * @test
     */
    public function canLoadNonce()
    {
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData)->setNonce($jsonData['nonce']);

        $this->assertEquals($this->littleEndian($jsonData['nonce']), $block->nonce()->endian(Uint32::LITTLE_ENDIAN));
    }

    /**
     * @test
     */
    public function canLoadPreviousBlockHash()
    {
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData);

        $this->assertEquals($jsonData['previousblockhash'], $block->previousBlockHash()->endian(Uint32::BIG_ENDIAN));
    }

    /**
     * @test
     */
    public function canLoadMerkleRoot()
    {
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData);

        $this->assertEquals($jsonData['merkleroot'], $block->merkleRoot()->endian(Uint32::BIG_ENDIAN));
    }

    /**
     * @test
     */
    public function canLoadHashedBits()
    {
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData);

        $this->assertEquals($jsonData['bits'], $block->bits()->endian(Uint32::BIG_ENDIAN));
    }

    /**
     * @test
     * @dataProvider jsonProvider
     */
    public function canGetHashFromKnownNonce($file)
    {
        $jsonData = BlockExplorerData::jsonDecodeFile($file);
        $block = BlockData::fromJson($jsonData)->setNonce($jsonData['nonce']);

        $this->assertEquals($jsonData['hash'], $block->blockHash()->endian(Uint32::BIG_ENDIAN));
    }

    public function jsonProvider()
    {
        return [
            ['BlockExplorerData/OneTransaction.json'],
            ['BlockExplorerData/MultipleTransaction.json'],
        ];
    }

    /**
     * @test
     * @group  Focus
     */
    public function canGenerateTarget()
    {
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData);

        $target = $block->target()->endian(Uint32::LITTLE_ENDIAN);

        $this->assertEquals('000000000000000000000000000000000000000000f6d000', $target);
    }

    /**
     * @test
     */
    public function canValidateAgainstTarget()
    {
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData)->setNonce($jsonData['nonce']);

        $this->assertTrue($block->isValid());
    }

    /**
     * @test
     */
    public function canTellIfNotValidWithNonce()
    {
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData)->setNonce(100);

        $this->assertFalse($block->isValid());
    }

    protected function littleEndian($value)
    {
        return implode((unpack('H*', pack('V*', $value))));
    }
}
