<?php declare(strict_types=1);

namespace Dive\Fez\Reapers;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Contracts\Reaper;
use Dive\Fez\Support\Makeable;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class RelevanceReaper implements Reaper
{
    use Makeable;

    public function reap(Route $route): ?Metable
    {
        return Collection::make($route->parameterNames)
            ->map(fn ($param) => Arr::get($route->parameters, $param))
            ->last(fn ($param) => $param instanceof Metable);
    }
}
