<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Tests;

use Ing200086\Miner\Hash;
use Ing200086\Miner\Uint32;
use PHPUnit\Framework\TestCase;

/**
 * Person tests example.
 */
class HashTest extends TestCase
{
    /**
     * @test
     */
    public function canAppendHexHashStringToEmptyHash()
    {
        $hash = Hash::fromHex('00000002' . '0597ba1f');

        $expected = [33554432, 532322053];

        $this->assertEquals($expected, $hash->toArray(Uint32::LITTLE_ENDIAN));
    }
}
