<?php declare(strict_types=1);

namespace Dive\Fez\Support;

trait Makeable
{
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }
}
