<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests;

use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    /**
     * @test
     */
    public function canParsePoolStringToArray()
    {
        $this->markTestSkipped('working on hex conversion');
        $original = '36caf078fcf348d1b56f301f1e6cc1d58d00bf85cb25f304ac24af2eb1935bc8';
        $expected = [2029046326, -783748100, 523268021, -708744162, -2051080051, 83043787, 783230124, -933522511];

        $this->assertEqualUint32Array($expected, Util::parseFromPool($original));
    }

    protected function assertEqualUint32Array($expected, $original)
    {
        $arr = [];
        foreach ($original as $value) {
            $arr[] = $value->dec();
        }

        $this->assertEquals($expected, $arr);
    }
}
