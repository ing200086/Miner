<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Hashes;

class HashFormatter
{
    protected $data;

    public function load($data)
    {
        $this->data = $data;
    }

    public function decimal()
    {
        return hexdec($this->data);
    }

    public function binary()
    {
        return decbin(hexdec($this->data));
    }
}
