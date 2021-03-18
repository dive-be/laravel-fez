<?php

namespace Dive\Fez;

use Closure;
use Dive\Fez\Contracts\Metaable;
use Dive\Fez\Exceptions\UnresolvableRouteException;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class MetaableFinder
{
    public const DEFAULT = 'fez';

    private ?Metaable $always = null;

    private Closure $route;

    public function alwaysFind(Metaable $metaable): void
    {
        $this->always = $metaable;
    }

    public function find(): ?Metaable
    {
        if ($this->always instanceof Metaable) {
            return $this->always;
        }

        $route = ($this->route)();

        if (! $route instanceof Route) {
            throw UnresolvableRouteException::make();
        }

        if (is_string($binding = Arr::pull($route->defaults, self::DEFAULT))) {
            $metaable = Arr::get($route->parameters, $binding);

            if ($metaable instanceof Metaable) {
                return $metaable;
            }
        }

        return Collection::make($route->parameterNames)
            ->map(fn ($param) => Arr::get($route->parameters, $param))
            ->reverse()
            ->first(fn ($param) => $param instanceof Metaable);
    }

    public function whenFound(Closure $callback): void
    {
        $metaable = $this->find();

        if ($metaable instanceof Metaable) {
            $callback($metaable);
        }
    }

    public function setRouteResolver(Closure $callback): self
    {
        $this->route = $callback;

        return $this;
    }
}
