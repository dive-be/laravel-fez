<?php declare(strict_types=1);

namespace Dive\Fez\Finders;

use Closure;
use Dive\Fez\Contracts\Finder;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Support\Makeable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Route;

class NameFinder implements Finder
{
    use Makeable;

    private static ?Closure $transformer = null;

    public static function transformNameUsing(?Closure $callback)
    {
        static::$transformer = $callback;
    }

    public function __construct(
        private Builder $query,
    ) {}

    public function find(Route $route): ?Metable
    {
        $name = $route->getName();

        // This will be handy for developers that add some kind of localization token
        // to the route's name
        if (! is_null(static::$transformer)) {
            $name = call_user_func(static::$transformer, $name);
        }

        return $this->query->where('name', $name)->first();
    }
}
