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
    public function __construct(private Closure $routeResolver) {}

    /**
     * @throws SorryUnresolvableRoute
     */
    public function find(): ?Metable
    {
        $route = $this->resolveRoute();
        $attempt = $this->seekUsingBinding($route);

        if ($attempt instanceof Metable) {
            return $attempt;
        }

        return $this->seekMostRelevant($route);
    }

    public function whenFound(Closure $callback): void
    {
        $metable = $this->find();

        if ($metable instanceof Metable) {
            $callback($metable);
        }
    }

    private function resolveRoute(): Route
    {
        $route = call_user_func($this->routeResolver);

        if (! $route instanceof Route) {
            throw SorryUnresolvableRoute::make();
        }

        return $route;
    }

    private function seekMostRelevant(Route $route): ?Metable
    {
        return Collection::make($route->parameterNames)
            ->map(fn ($param) => Arr::get($route->parameters, $param))
            ->last(fn ($param) => $param instanceof Metable);
    }

    private function seekUsingBinding(Route $route): ?Metable
    {
        $binding = Arr::pull($route->defaults, static::class);

        if (! is_string($binding)) {
            return null;
        }

        return Arr::get($route->parameters, $binding);
    }
}
