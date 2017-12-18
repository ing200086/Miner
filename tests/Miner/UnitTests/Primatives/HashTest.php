<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Primatives;

use Ing200086\Miner\Hashes\Hash;
use Ing200086\Miner\Hashes\HashCreatorInterface;
use Ing200086\Miner\Hashes\HashEndianSwapperInterface;
use Ing200086\Miner\Hashes\HashFormatterInterface;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{
    /**
     * @test
     */
    public function canOutputHashCreatorInterface()
    {
        $hash = Hash::from();

        $this->assertInstanceOf(HashCreatorInterface::class, $hash);
    }

    /**
     * @test
     */
    public function canProvideEndianSwapper()
    {
        $hash = Hash::from()::hex('aa');

        $this->assertInstanceOf(HashEndianSwapperInterface::class, $hash->endian());
    }

    /**
     * @test
     */
    public function canProvideFormatter()
    {
        $hash = Hash::from()::hex('aa');

        $this->assertInstanceOf(HashFormatterInterface::class, $hash->into());
    }

    /**
     * @test
     */
    public function canAppendTwoHashObjects()
    {
        $A = Hash::from()::hex('1800d0f6');
        $B = Hash::from()::hex('10101010');

        $C = $A->append($B);

        $this->assertEquals('1800d0f610101010', $C);
    }

    /**
     * @test
     * @group Focus
     */
    public function canPerformSha256Hashing()
    {
        $source = 'abcdef01';
        $expected = '0ff00797339fb73386351d32fd3a0092f28e87f3978b7b08c5938950d18313b4';

        $actual = Hash::from()::hex($source)->sha256()->into()->hex();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @group  Focus
     */
    public function performHashOnExpectedSizedString()
    {
        $source = '01000000' .
                    '81cd02ab7e569e8bcd9317e2fe99f2de44d49ab2b8851ba4a308000000000000' .
                    'e320b6c2fffc8d750423db8b1eb942ae710e951ed797f7affc8892b0f1fc122b' .
                    'c7f5d74d' .
                    'f2b9441a' .
                    '42a14695';
        $expected = '1dbd981fe6985776b644b173a4d0385ddc1aa2a829688d1e0000000000000000';

        $actual = Hash::from()::hex($source)->sha256()->sha256();
        $this->assertEquals($expected, $actual);
    }
}
