<?php

namespace Dive\Fez\Models;

use Closure;
use Dive\Fez\Concerns\ProvidesMetaData;
use Dive\Fez\Contracts\Metaable;
use Dive\Fez\Contracts\StaticPage as Contract;
use Dive\Fez\Fez;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;

/**
 * @property string|null $description
 * @property string      $key
 * @property string|null $name
 */
class StaticPage extends Model implements Contract, Metaable
{
    use ProvidesMetaData;

    protected static ?Closure $resolveKeyUsing = null;

    protected $guarded = [];

    public static function resolve(Fez $fez, Route $route): self
    {
        $keyResolver = self::$resolveKeyUsing ?? fn (Route $route) => $route->getName();

        return tap(
            self::query()->where('key', $keyResolver($route))->firstOrNew(),
            fn (self $page) => $page->exists && $fez->useModel($page),
        );
    }

    public static function resolveKeyUsing(Closure $callback): void
    {
        self::$resolveKeyUsing = $callback;
    }
}
