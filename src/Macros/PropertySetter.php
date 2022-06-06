<?php declare(strict_types=1);

namespace Dive\Fez\Macros;

use Closure;
use Dive\Fez\Fez;

/**
 * @mixin \Illuminate\View\View
 */
class PropertySetter
{
    public function fez(): Closure
    {
        return function (array|string $property, ?string $value = null) {
            Fez::set($property, $value);

            return $this;
        };
    }
}
