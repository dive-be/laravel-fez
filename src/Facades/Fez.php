<?php declare(strict_types=1);

namespace Dive\Fez\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dive\Fez\AlternatePage          alternatePage()
 * @method static \Dive\Fez\FezManager             description(string $description)
 * @method static \Dive\Fez\FezManager             except(...$features)
 * @method static \Dive\Fez\FezManager             for(\Dive\Fez\Contracts\Metable $model)
 * @method static \Dive\Fez\Component              get(string $feature)
 * @method static \Dive\Fez\FezManager             image(string $image)
 * @method static \Dive\Fez\MetaElements           metaElements()
 * @method static \Dive\Fez\Contracts\Metable|null model()
 * @method static \Dive\Fez\FezManager             only(...$features)
 * @method static \Dive\Fez\OpenGraph\RichObject   openGraph()
 * @method static \Dive\Fez\FezManager             set(array|string $property, string|null $value = null)
 * @method static \Dive\Fez\FezManager             title(string $title)
 * @method static \Dive\Fez\TwitterCards\Card      twitterCards()
 */
class Fez extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'fez';
    }
}
