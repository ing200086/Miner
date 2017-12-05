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
use Ing200086\Miner\Hashes\HashFormatter;
use Ing200086\Miner\Hashes\HashInterface;

/**
 */
class HashFormatterTest extends TestCase
{
    /**
     * @test
     */
    public function canOutputAsHexidecimal()
    {
        $hash = $this->mockHash('0ed00912');

        $formatter = new HashFormatter();
        $formatter->load($hash);

        $this->assertEquals('0ed00912', $formatter->hex());
    }

    /**
     * @test
     */
    public function canOutputAsDecimal()
    {
        $hash = $this->mockHash('0ed00912');

        $formatter = new HashFormatter();
        $formatter->load($hash);

        $this->assertEquals(248514834, $formatter->decimal());
    }

    /**
     * @test
     */
    public function canOutputAsBinary()
    {
        $hash = $this->mockHash('0ed00912');

        $formatter = new HashFormatter();
        $formatter->load($hash);

        $this->assertEquals('1110110100000000100100010010', $formatter->binary());
    }

    protected function mockHash($returnString)
    {
        $hash = \Mockery::mock(HashInterface::class);
        $hash->shouldReceive('__toString')->once()->andReturn($returnString);

        return $hash;
    }
}
