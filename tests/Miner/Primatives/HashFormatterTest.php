<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests\Primatives;

use Ing200086\Miner\Hashes\HashFormatter;
use Ing200086\Miner\Hashes\HashInterface;
use PHPUnit\Framework\TestCase;

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
        $source = '0ed00912';
        $hash = $this->mockHash($source);

        $formatter = new HashFormatter();
        $formatter->load($hash);
        $expected = hex2bin($source);

        $this->assertEquals($expected, $formatter->binary());
    }

    protected function mockHash($returnString)
    {
        $hash = \Mockery::mock(HashInterface::class);
        $hash->shouldReceive('__toString')->once()->andReturn($returnString);

        return $hash;
    }
}
