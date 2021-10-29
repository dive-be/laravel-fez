<?php declare(strict_types=1);

namespace Dive\Fez\Macros;

use Closure;
use Dive\Fez\RouteConfig;
use Illuminate\Routing\Route;

class RouteConfigurator
{
    public static function register()
    {
        Route::macro('fez', static::macro());
    }

    private static function macro(): Closure
    {
        return function (Closure $callback) {
            /** @var Route $this */
            $config = RouteConfig::make();

            $callback($config);

            return $this->defaults('fez', $config->toArray());
        };
    }
}
