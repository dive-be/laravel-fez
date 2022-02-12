<?php declare(strict_types=1);

namespace Dive\Fez\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

trait WithRoutes
{
    protected static function getRouteIds(): Collection
    {
        return static::getRoutes()
            ->map(static fn ($route) => $route->defaults['fez']['attributes']['model'])
            ->unique();
    }

    protected static function getRoutes(): Collection
    {
        return Collection::make(Route::getRoutes())
            ->filter(static fn ($route) => array_key_exists('fez', $route->defaults))
            ->filter(static fn ($route) => $route->defaults['fez']['strategy'] === 'id');
    }

    /**
     * @return Builder<\Dive\Fez\Models\Route>
     */
    protected static function newQuery(): Builder
    {
        return call_user_func([Config::get('fez.models.route'), 'query']);
    }
}
