<?php declare(strict_types=1);

namespace Dive\Fez\Models;

use Closure;
use Dive\Fez\Contracts\Metable;
use Dive\Fez\Contracts\Route as Contract;
use Dive\Fez\Models\Concerns\HasMetaData;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $description
 * @property string      $key
 * @property string|null $name
 */
class Route extends Model implements Contract, Metable
{
    use HasMetaData;

    public const NAME = 'route';

    protected static Closure $keyUsing;

    protected $guarded = ['id'];

    public static function keyUsing(Closure $callback)
    {
        self::$keyUsing = $callback;
    }

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function resolve(\Illuminate\Routing\Route $route): self
    {
        /** @var self $model */
        $model = self::query()
            ->where('key', call_user_func(self::$keyUsing, $route))
            ->firstOrFail();

        $route->parameterNames[] = self::NAME;
        $route->setParameter(self::NAME, $model);

        return $model;
    }
}
