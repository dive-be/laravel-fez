<?php

namespace Dive\Fez\Models;

use Closure;
use Dive\Fez\Contracts\Metaable;
use Dive\Fez\Fez;
use Dive\Fez\Models\Concerns\ProvidesMetaData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;

/**
 * @property string|null $description
 * @property string      $key
 * @property string|null $name
 */
class StaticPage extends Model implements Metaable
{
    use ProvidesMetaData;

    protected static ?Closure $resolveKeyUsing = null;

    protected $guarded = [];

    public static function resolveKeyUsing(Closure $callback)
    {
        self::$resolveKeyUsing = $callback;
    }

    public static function resolve(Fez $fez, Route $route)
    {
        $keyResolver = self::$resolveKeyUsing ?? fn (Route $route) => $route->getName();

        $page = self::query()->where('key', $keyResolver($route))->firstOrNew();

        $fez->use($page);

        return $page;
    }
}
