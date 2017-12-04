<?php

/*
 * miner.
 *
 * @license MIT
 * @author Ing200086 <ing200086@gmail.com>
 */

declare(strict_types=1);

namespace ing200086\Miner\Enums;

abstract class AbstractEnum
{
    protected $value;

    final public function __construct($value)
    {
        if (!$this->isValidConstant($value)) {
            throw new \InvalidArgumentException();
        }
        $this->value = $value;
    }

    final protected function isValidConstant($value)
    {
        $obj = new \ReflectionClass($this);

        return in_array($value, $obj->getConstants());
    }

    final public function __toString()
    {
        return $this->value;
    }
}
