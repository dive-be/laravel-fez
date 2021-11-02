<?php declare(strict_types=1);

namespace Dive\Fez\Finders;

use Closure;
use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Models\Route as Model;
use Dive\Fez\Support\Makeable;
use Illuminate\Routing\Route;

class NameFinder implements Finder
{
    use Makeable;

    private static ?Closure $transformer = null;

    public static function transformNameUsing(?Closure $callback)
    {
        static::$transformer = $callback;
    }

    public function find(Route $route): ?Metable
    {
        $name = $route->getName();

        // This will be handy for developers that add some kind of localization token
        // to the route's name
        if (! is_null(static::$transformer)) {
            $name = call_user_func(static::$transformer, $name);
        }

        return Model::query()->where(compact('name'))->first();
    }
}
