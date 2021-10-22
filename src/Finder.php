<?php

namespace Dive\Fez;

use Closure;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Exceptions\SorryUnresolvableRoute;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Finder
{
    private ?Metable $always = null;

    public function __construct(private Closure $routeResolver) {}

    public function alwaysFind(Metable $metable): void
    {
        $this->always = $metable;
    }

    public function find(): ?Metable
    {
        if ($this->always instanceof Metable) {
            return $this->always;
        }

        $route = call_user_func($this->routeResolver);

        if (! $route instanceof Route) {
            throw SorryUnresolvableRoute::make();
        }

        if (is_string($binding = Arr::pull($route->defaults, static::class))) {
            $metable = Arr::get($route->parameters, $binding);

            if ($metable instanceof Metable) {
                return $metable;
            }
        }

        return Collection::make($route->parameterNames)
            ->map(fn ($param) => Arr::get($route->parameters, $param))
            ->last(fn ($param) => $param instanceof Metable);
    }

    public function whenFound(Closure $callback): void
    {
        $metable = $this->find();

        if ($metable instanceof Metable) {
            $callback($metable);
        }
    }
}
