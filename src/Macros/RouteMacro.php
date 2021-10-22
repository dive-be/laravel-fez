<?php

namespace Dive\Fez\Macros;

use Dive\Fez\Contracts\MacroRegistrar;
use Dive\Fez\Finder;
use Illuminate\Routing\Route;

class RouteMacro implements MacroRegistrar
{
    public static function register()
    {
        Route::macro('fez', function (string $binding) {
            $this->defaults(Finder::class, $binding);
        });
    }
}
