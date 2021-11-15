<?php declare(strict_types=1);

namespace Dive\Fez\Commands\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;

trait WithRoutes
{
    private function getRoutes(): Collection
    {
        return Collection::make($this->getLaravel()->make('router')->getRoutes())
            ->filter(static fn (Route $route) => array_key_exists('fez', $route->defaults))
            ->filter(static fn (Route $route) => $route->defaults['fez']['strategy'] === 'id')
            ->map(static fn (Route $route) => $route->defaults['fez']['attributes']['model'])
            ->unique();
    }

    private function newQuery(): Builder
    {
        return call_user_func([
            $this->getLaravel()->make('config')->get('fez.models.route'),
            'query',
        ]);
    }
}
