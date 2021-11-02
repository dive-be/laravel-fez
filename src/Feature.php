<?php declare(strict_types=1);

namespace Dive\Fez;

use Illuminate\Support\Facades\Config;

class Feature
{
    public static function all(): array
    {
        return [
            static::alternatePage(),
            static::metaElements(),
            static::openGraph(),
            static::twitterCards(),
        ];
    }

    public static function alternatePage(): string
    {
        return 'alternatePage';
    }

    public static function enabled(): array
    {
        return array_values(
            array_intersect(array_unique(Config::get('fez.features')), static::all())
        );
    }

    public static function metaElements(): string
    {
        return 'metaElements';
    }

    public static function openGraph(): string
    {
        return 'openGraph';
    }

    public static function twitterCards(): string
    {
        return 'twitterCards';
    }
}
