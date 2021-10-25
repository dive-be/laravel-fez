<?php

namespace Dive\Fez\Macros;

use Closure;
use Dive\Fez\Contracts\MacroRegistrar;
use Illuminate\View\View;

class ViewMacro implements MacroRegistrar
{
    public static function register()
    {
        View::macro('fez', static::callback());
    }

    private static function callback(): Closure
    {
        return function (array|string $property, $value = null) {
            fez()->set($property, $value);

            return $this;
        };
    }
}
