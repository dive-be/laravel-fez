<?php declare(strict_types=1);

namespace Dive\Fez\Macros;

use Closure;
use Dive\Fez\Facades\Fez;
use Illuminate\View\View;

class PropertySetter
{
    public static function register()
    {
        View::macro('fez', static::macro());
    }

    public static function macro(): Closure
    {
        return function (array|string $property, ?string $value = null): View {
            Fez::set($property, $value);

            return $this;
        };
    }
}
