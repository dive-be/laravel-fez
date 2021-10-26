<?php declare(strict_types=1);

namespace Dive\Fez\Macros;

use Closure;
use Illuminate\View\View;

class ViewMacro
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
