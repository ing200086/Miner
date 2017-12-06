<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Hashes;

class HashFormatter implements HashFormatterInterface
{
    protected $data;

    public function load(HashInterface $data): HashFormatterInterface
    {
        $this->data = $data;
        return $this;
    }

    public function hex()
    {
        return $this->data->__toString();
    }

    public function hexSubstr(int $start = 0, int $end = 0, int $padRight = 0)
    {
        $fullHex = $this->hex();

        if ($end > strlen($fullHex)) {
            throw new \Exception("End of substring is out of bounds");
        }

        return str_pad(substr($fullHex, $start, $end), $padRight, '0', STR_PAD_RIGHT);
    }

    public function decimal()
    {
        return hexdec($this->data);
    }

    public function decimalSubstr(int $start = 0, int $end = 0)
    {
        return hexdec(substr($this->hex(), $start, $end));
    }

    public function binary()
    {
        return hex2bin($this->hex());
    }
}
