<?php declare(strict_types=1);

namespace Dive\Fez\Finders;

use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Exceptions\MetableNotFoundException;
use Dive\Utils\Makeable;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class RelevanceFinder implements Finder
{
    use Makeable;

    public function find(Route $route): Metable
    {
        return Collection::make($route->parameterNames)
            ->map(static fn ($param) => Arr::get($route->parameters, $param))
            ->last(static fn ($param) => $param instanceof Metable, MetableNotFoundException::throw(...));
    }
}
