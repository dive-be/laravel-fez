<?php

namespace Dive\Fez\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string generate()
 * @method static \Dive\Fez\Component|null get(string $component)
 * @method static \Dive\Fez\Fez set(array|string $property, $value = null)
 * @method static array toArray()
 * @method static \Dive\Fez\Fez use(\Dive\Fez\Contracts\Metaable $metaable)
 */
class Fez extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fez';
    }
}
