<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Primatives;

use PHPUnit\Framework\TestCase;
use Ing200086\Miner\Hashes\Hash;
use Ing200086\Miner\Hashes\HashCreatorInterface;
use Ing200086\Miner\Hashes\HashFormatterInterface;
use Ing200086\Miner\Hashes\HashEndianSwapperInterface;

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
     */
    public function canPerformSha256Hashing()
    {
        $source = '76543210';
        $expected = '7072828bceb61e5c0d7567b645821db630f121df0fb8e881fed5ee8a9b7058a1';

        $actual = Hash::from()::hex($source)->sha256()->into()->hex();

        $this->assertEquals($expected, $actual);
    }
}
