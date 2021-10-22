<?php

namespace Dive\Fez\Macros;

use Dive\Fez\Contracts\MacroRegistrar;
use Illuminate\View\View;

class ViewMacro implements MacroRegistrar
{
    public static function register()
    {
        View::macro('fez', function (array|string $property, $value = null) {
            fez()->set($property, $value);

            return $this;
        });
    }
}
