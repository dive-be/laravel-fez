<?php

namespace Dive\Fez;

use Closure;
use Dive\Fez\Contracts\Metaable;
use Dive\Fez\Exceptions\SorryUnresolvableRoute;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Finder
{
    private ?Metaable $always = null;

    public function __construct(private Closure $routeResolver) {}

    public function alwaysFind(Metaable $metaable): void
    {
        $this->always = $metaable;
    }

    public function find(): ?Metaable
    {
        if ($this->always instanceof Metaable) {
            return $this->always;
        }

        $route = call_user_func($this->routeResolver);

        if (! $route instanceof Route) {
            throw SorryUnresolvableRoute::make();
        }

        if (is_string($binding = Arr::pull($route->defaults, static::class))) {
            $metaable = Arr::get($route->parameters, $binding);

            if ($metaable instanceof Metaable) {
                return $metaable;
            }
        }

        return Collection::make($route->parameterNames)
            ->map(fn ($param) => Arr::get($route->parameters, $param))
            ->last(fn ($param) => $param instanceof Metaable);
    }

    public function whenFound(Closure $callback): void
    {
        $metaable = $this->find();

        if ($metaable instanceof Metaable) {
            $callback($metaable);
        }
    }
}
