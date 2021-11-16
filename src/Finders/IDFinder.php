<?php declare(strict_types=1);

namespace Dive\Fez\Finders;

use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Support\Makeable;
use Dive\Fez\Support\WithRoutes;
use Illuminate\Routing\Route;

class IDFinder implements Finder
{
    use Makeable;
    use WithRoutes;

    public function find(Route $route): ?Metable
    {
        return $this
            ->newQuery()
            ->whereKey($route->defaults['fez']['attributes']['model'])
            ->first();
    }
}
