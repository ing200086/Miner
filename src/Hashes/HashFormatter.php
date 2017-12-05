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

    public function load(HashInterface $data)
    {
        $this->data = $data;
    }

    public function hex()
    {
        return $this->data->__toString();
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
