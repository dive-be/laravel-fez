<?php declare(strict_types=1);

namespace Dive\Fez\Contracts;

use Closure;

interface Route
{
    public static function keyUsing(Closure $callback);

    public static function resolve(\Illuminate\Routing\Route $route): self;
}
