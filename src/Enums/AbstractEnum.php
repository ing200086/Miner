<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace Ing200086\Miner\Enums;

abstract class AbstractEnum
{
    protected $value;

    final public function __construct($value)
    {
        $obj = new \ReflectionClass($this);

        if (!in_array($value, $obj->getConstants())) {
            throw new \InvalidArgumentException();
        }

        $this->value = $value;
    }

    final public function __toString()
    {
        return $this->value;
    }
}
