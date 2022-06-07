<?php declare(strict_types=1);

namespace Dive\Fez;

use Illuminate\Support\Facades\Config;

class Feature
{
    final public const ALTERNATE_PAGE = 'alternatePage';
    final public const META_ELEMENTS = 'metaElements';
    final public const OPEN_GRAPH = 'openGraph';
    final public const TWITTER_CARDS = 'twitterCards';

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
        return self::ALTERNATE_PAGE;
    }

    public static function enabled(): array
    {
        return array_values(
            array_intersect(array_unique(Config::get('fez.features')), static::all())
        );
    }

    public static function metaElements(): string
    {
        return self::META_ELEMENTS;
    }

    public static function openGraph(): string
    {
        return self::OPEN_GRAPH;
    }

    public static function twitterCards(): string
    {
        return self::TWITTER_CARDS;
    }
}
