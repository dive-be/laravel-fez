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
        return function (Closure|bool|int|string $value, ...$arguments): Route {
            $config = RouteConfig::make();

            if (is_string($value)) {
                call_user_func_array([$config, $value], $arguments);
            } elseif (is_int($value)) {
                $config->id($value);
            } elseif (is_bool($value)) {
                $config->none();
            } else {
                $value($config);
            }

            return $this->defaults('fez', $config->toArray());
        };
    }
}
