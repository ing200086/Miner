<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests;

use Ing200086\Miner\Block;
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class BlockTest extends TestCase
{
    /**
     * @test
     */
    public function canTakeDataFromPoolAndStoreAsLittleEndian()
    {
        // $this->markTestIncomplete("TestingSingleWord");
        $poolData = '00000002 0597ba1f 0cd423b2 a3abb025 9a54ee5f 783077a4 ad45fb62 00000218'
                  . '00000000 8348d133 9e6797e2 b15e9a3f 2fb7da08 768e99f0 2727e422 7e02903e'
                  . '43a42b31 51155310 1a051f3c 00000000 00000080 00000000 00000000 00000000'
                  . '00000000 00000000 00000000 00000000 00000000 00000000 00000000 80020000';
        $expected = '02000000 1fba9705 b223d40c 25b0aba3 5fee549a a4773078 62fb45ad 18020000'
                  . '00000000 33d14883 e297679e 3f9a5eb1 08dab72f f0998e76 22e42727 3e90027e'
                  . '312ba443 10531551 3c1f051a 00000000 80000000 00000000 00000000 00000000'
                  . '00000000 00000000 00000000 00000000 00000000 00000000 00000000 00000280';

        // 20000001 fba9705b 223d40c2 5b0aba35 fee549aa 47730786 2fb45ad1 80200000
        // 33d14883 e297679e 3f9a5eb1 8dab72ff 0998e762 2e427273 e90027e3 12ba4431
        // 05315513 c1f051a0 80000000 00000000 00280

        $poolData = str_replace(' ', '', $poolData);
        $expected = str_replace(' ', '', $expected);

        // var_dump($poolData);

        $block = Block::create();
        $block->loadFromPoolString($poolData);

        // var_dump(Block::splitHexStringByUint32BitChunks($poolData)[0]);

        $this->assertEquals($expected, $block->littleEndianString());
    }
}
