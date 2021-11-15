<?php declare(strict_types=1);

namespace Dive\Fez\Finders;

use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Support\Makeable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Config;

class IDFinder implements Finder
{
    use Makeable;

    public function find(Route $route): ?Metable
    {
        return $this
            ->newQuery()
            ->whereKey($route->defaults['fez']['attributes']['model'])
            ->first();
    }

    private function newQuery(): Builder
    {
        return call_user_func([Config::get('fez.models.route'), 'query']);
    }
}
