<?php declare(strict_types=1);

namespace Dive\Fez\Reapers;

use Closure;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Contracts\Reaper;
use Dive\Fez\Models\Route as Model;
use Dive\Fez\Support\Makeable;
use Illuminate\Routing\Route;

class NameReaper implements Reaper
{
    use Makeable;

    private static Closure $transformNameUsing;

    public function reap(Route $route): ?Metable
    {
        $name = $route->getName();

        // This will be handy for developers that add some kind of localization token
        // to the route's name
        if (isset(static::$transformNameUsing)) {
            $name = call_user_func(static::$transformNameUsing, $name);
        }

        return Model::query()->where(compact('name'))->first();
    }
}
