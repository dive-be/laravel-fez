<?php declare(strict_types=1);

namespace Dive\Fez\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

trait WithRoutes
{
    protected function getRouteIds(): Collection
    {
        return $this
            ->getRoutes()
            ->map(static fn ($route) => $route->defaults['fez']['attributes']['model'])
            ->unique();
    }

    protected function getRoutes(): Collection
    {
        return Collection::make(Route::getRoutes())
            ->filter(static fn ($route) => array_key_exists('fez', $route->defaults))
            ->filter(static fn ($route) => $route->defaults['fez']['strategy'] === 'id');
    }

    protected function newQuery(): Builder
    {
        return call_user_func([Config::get('fez.models.route'), 'query']);
    }
}
