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
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class BlockDataTest extends TestCase
{

    /**
     * @test
     */
    public function canLoadFromBlockExplorerJson()
    {
        $jsonData = BlockExplorerData::oneTransaction();
        $block = BlockData::fromJson($jsonData);

        $this->assertEquals($jsonData['previousblockhash'], $block->previousBlockHash());
    }
}
