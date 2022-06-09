<?php declare(strict_types=1);

namespace Dive\Fez\Macros;

use Closure;
use Dive\Fez\RouteConfig;

/**
 * @mixin \Illuminate\Routing\Route
 */
class RouteConfigurator
{
    public function fez(): Closure
    {
        return function (Closure|bool|string $value, ...$arguments) {
            $config = RouteConfig::make();

            if (is_string($value)) {
                call_user_func_array([$config, $value], $arguments);
            } elseif (is_bool($value)) {
                $config->none();
            } else {
                $value($config);
            }

            return $this->defaults('fez', $config->toArray());
        };
    }
}
