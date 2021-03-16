<?php

namespace Dive\Fez\Contracts;

use Closure;
use Dive\Fez\Fez;
use Illuminate\Routing\Route;

interface StaticPage
{
    public static function resolve(Fez $fez, Route $route): self;

    public static function resolveKeyUsing(Closure $callback): void;
}
