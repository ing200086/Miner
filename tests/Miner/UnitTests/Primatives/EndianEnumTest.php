<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\UnitTests\Primatives;

use Ing200086\Miner\Enums\Endian;
use PHPUnit\Framework\TestCase;

/**
 * @group  Focus
 */
class EndianEnumTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateValidEnum()
    {
        $enum = new Endian(Endian::BIG);

        $this->assertInstanceOf(Endian::class, $enum);
    }

    /**
     * @test
     */
    public function canThrowErrorForInvalidEnum()
    {
        $this->expectException(\InvalidArgumentException::class);
        $enum = new Endian('NotReal');
    }

    /**
     * @test
     */
    public function endianObjectWillHaveStringValue()
    {
        $enum = new Endian(Endian::BIG);

        $this->assertEquals(Endian::BIG, $enum);
    }
}
