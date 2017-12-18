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
use Ing200086\Miner\Blocks\Unclaimed;
use Ing200086\Miner\Enums\Endian;
use Ing200086\Miner\Hashes\Hash;
use Ing200086\Miner\Tests\BlockExplorerData\DataProvider;
use PHPUnit\Framework\TestCase;

class UnclaimedTest extends TestCase
{
    /**
     * @test
     * @group  Focus
     */
    public function canBuildCorrectHexStringToBeHashed()
    {
        $json = DataProvider::otherTransaction();
        $builder = new JsonBuilder($json);
        $data = $builder->build();
        $unclaimed = new Unclaimed($builder->build());

        $expected = Hash::from()::hex('01000000' .
                    '81cd02ab7e569e8bcd9317e2fe99f2de44d49ab2b8851ba4a308000000000000' .
                    'e320b6c2fffc8d750423db8b1eb942ae710e951ed797f7affc8892b0f1fc122b' .
                    'c7f5d74d' .
                    'f2b9441a' .
                    '42a14695', new Endian(Endian::LITTLE));

        $this->assertEquals($expected, $unclaimed->result(2504433986, false));
    }

    /**
     * @test
     * @group  Focus
     */
    public function canReturnTheDoubleHashedHex()
    {
        $json = DataProvider::otherTransaction();
        $builder = new JsonBuilder($json);
        $data = $builder->build();
        $unclaimed = new Unclaimed($builder->build());

        $expected = Hash::from()::hex(
            '1dbd981fe6985776b644b173a4d0385ddc1aa2a829688d1e0000000000000000',
            new Endian(Endian::LITTLE)
        );
        $actual = $unclaimed->result(2504433986, true);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @group  Focus
     */
    public function canValidateNonce()
    {
        $json = DataProvider::otherTransaction();
        $builder = new JsonBuilder($json);
        $data = $builder->build();
        $unclaimed = new Unclaimed($builder->build());

        $expected = Hash::from()::hex(
            '1dbd981fe6985776b644b173a4d0385ddc1aa2a829688d1e0000000000000000',
            new Endian(Endian::LITTLE)
        );

        $this->assertTrue($unclaimed->testNonce(2504433986));
    }
}
