<?php declare(strict_types=1);

namespace Dive\Fez\Macros;

use Closure;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Factories\FinderFactory;
use Dive\Fez\RouteConfig;
use Illuminate\Routing\Route;

class MetableFinder
{
    public static function register()
    {
        Route::macro('metable', static::macro());
    }

    private static function macro(): Closure
    {
        return function (): ?Metable {
            $config = $this->defaults['fez'] ?? RouteConfig::default()->toArray();

            return FinderFactory::make()
                ->create(...$config)
                ->find($this);
        };
    }
}
