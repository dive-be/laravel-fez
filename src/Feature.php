<?php declare(strict_types=1);

namespace Dive\Fez;

use Illuminate\Support\Facades\Config;

class Feature
{
    public static function all(): array
    {
        return [
            static::alternatePage(),
            static::meta(),
            static::openGraph(),
            static::twitterCards(),
        ];
    }

    public static function alternatePage(): string
    {
        return __FUNCTION__;
    }

    public static function enabled(): array
    {
        return array_intersect(array_unique(Config::get('fez.features')), static::all());
    }

    public static function meta(): string
    {
        return __FUNCTION__;
    }

    public static function openGraph(): string
    {
        return __FUNCTION__;
    }

    public static function twitterCards(): string
    {
        return __FUNCTION__;
    }
}
