<?php

namespace Dive\Fez\Concerns;

trait Makeable
{
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }
}
