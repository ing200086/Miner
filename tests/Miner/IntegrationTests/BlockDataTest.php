<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Integration;

use Ing200086\Miner\Blocks\Builders\JsonBuilder;
use Ing200086\Miner\Tests\BlockExplorerData\DataProvider;
use PHPUnit\Framework\TestCase;

class BlockDataTest extends TestCase
{
    /**
     * @test
     */
    public function canGetPartialHashCorrectly()
    {
        $json = DataProvider::emptyTransaction();
        $builder = new JsonBuilder($json);
        $data = $builder->build();

        $this->assertEquals(
            '0a00000015bbbbbb14aaaaaa13ffffff12eeeeee11dddddd10ccccccb9bbbbbba8aaaaaab7' .
            'bbbbbba6aaaaaaf5ffffffe4eeeeeed3ddddddc2ccccccb1bbbbbba0aaaaaa10000000ffffffff',
            $data->partialHash()->__toString()
        );
    }
}
