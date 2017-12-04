<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Blocks;

use Ing200086\Miner\Blocks\Unclaimed as UnclaimedBlock;
use Ing200086\Miner\Tests\BlockExplorerData\DataProvider;
use Ing200086\Miner\Uint32;
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class ClaimedTest extends TestCase
{
    /**
     * @test
     */
    public function canLoadNonce()
    {
        $this->markTestIncomplete('Refactoring');
        $jsonData = DataProvider::oneTransaction();
        $block = UnclaimedBlock::fromJson($jsonData)->setNonce($jsonData['nonce']);

        $this->assertEquals($this->littleEndian($jsonData['nonce']), $block->nonce()->endian(Uint32::LITTLE_ENDIAN));
    }

    /**
     * @test
     * @dataProvider jsonProvider
     */
    public function canGetHashFromKnownNonce($file)
    {
        $this->markTestIncomplete('Refactoring');
        $jsonData = DataProvider::jsonDecodeFile($file);
        $block = UnclaimedBlock::fromJson($jsonData)->setNonce($jsonData['nonce']);

        $this->assertEquals($jsonData['hash'], $block->blockHash()->endian(Uint32::BIG_ENDIAN));
    }

    /**
     * @test
     */
    public function canValidateAgainstTarget()
    {
        $this->markTestIncomplete('Refactoring');
        $jsonData = DataProvider::oneTransaction();
        $block = UnclaimedBlock::fromJson($jsonData)->setNonce($jsonData['nonce']);

        $this->assertTrue($block->isValid());
    }

    /**
     * @test
     */
    public function canTellIfNotValidWithNonce()
    {
        $this->markTestIncomplete('Refactoring');
        $jsonData = DataProvider::oneTransaction();
        $block = UnclaimedBlock::fromJson($jsonData)->setNonce(100);

        $this->assertFalse($block->isValid());
    }

    public function jsonProvider()
    {
        return [
            ['DataProvider/OneTransaction.json'],
            ['DataProvider/MultipleTransaction.json'],
        ];
    }
}
