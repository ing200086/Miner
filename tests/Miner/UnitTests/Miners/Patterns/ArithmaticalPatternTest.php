<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\UnitTests\Miners;

use Ing200086\Miner\Miners\Patterns\ArithmaticalPattern;
use PHPUnit\Framework\TestCase;

class ArithmaticalPatternTest extends TestCase
{
    /**
     * @test
     */
    public function canMakeDefaultArithmaticalPattern()
    {
        $pattern = new ArithmaticalPattern();

        $this->assertInstanceOf(ArithmaticalPattern::class, $pattern);
    }

    /**
     * @test
     */
    public function canIncrementToNextValue()
    {
        $pattern = new ArithmaticalPattern();

        $this->assertEquals(0, $pattern->current());
        $pattern->next();
        $this->assertEquals(1, $pattern->current());
    }

    /**
     * @test
     */
    public function canLoopWhenReachedMaxInteger()
    {
        $maxInt = 2147483647;
        $pattern = new ArithmaticalPattern($maxInt - 1);

        $this->assertEquals($maxInt - 1, $pattern->current());
        $pattern->next();
        $this->assertEquals($maxInt, $pattern->current());
        $pattern->next();
        $this->assertEquals(0, $pattern->current());
    }
}
