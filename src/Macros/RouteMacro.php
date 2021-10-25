<?php

namespace Dive\Fez\Macros;

use Closure;
use Dive\Fez\Contracts\MacroRegistrar;
use Dive\Fez\Finder;
use Illuminate\Routing\Route;

class RouteMacro implements MacroRegistrar
{
    public static function register()
    {
        Route::macro('fez', static::callback());
    }

    private static function callback(): Closure
    {
        return function (string $binding) {
            return $this->defaults(Finder::class, $binding);
        };
    }
}
