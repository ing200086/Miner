<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Acceptance;

use Ing200086\Miner\Blocks\Builders\JsonBuilder;
use Ing200086\Miner\Blocks\Unclaimed;
use Ing200086\Miner\Miners\ArithmaticalMiner;
use Ing200086\Miner\Miners\Patterns\ArithmaticalPattern;
use Ing200086\Miner\Tests\BlockExplorerData\DataProvider;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    /**
     * @test
     * @large
     */
    public function canTakeABlockFromLocalJsonFileAndFindNonce()
    {
        $miner = new ArithmaticalMiner(new ArithmaticalPattern(248514834 - 50000));
        $json = DataProvider::oneTransaction();
        $builder = new JsonBuilder($json);
        $unclaimed = new Unclaimed($builder->build());

        $miner->maxCycles(50000);
        $miner->load($unclaimed)->run();
        $this->assertEquals(50000, $miner->cycles());
    }
}
