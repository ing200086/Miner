<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Blocks;

use Ing200086\Miner\Blocks\Builders\JsonBuilder;
use Ing200086\Miner\Blocks\Data\BlockData;
use Ing200086\Miner\Tests\BlockExplorerData\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class JsonBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function canLoadFromJsonFile()
    {
        $json = DataProvider::oneTransaction();
        $builder = new JsonBuilder();

        $builder->load($json);
        $blockData = $builder->build();

        $this->assertInstanceOf(BlockData::class, $blockData);

        $this->assertEquals(
            $json['previousblockhash'],
            $blockData->previousBlockHash()->endian()->big()->into()->hex()
        );
    }
}
