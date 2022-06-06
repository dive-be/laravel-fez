<?php declare(strict_types=1);

namespace Dive\Fez;

use Illuminate\Support\Facades\Facade;

/**
 * @method static AlternatePage          alternatePage()
 * @method static Manager                description(string $description)
 * @method static Manager                except(...$features)
 * @method static Manager                for(Contracts\Metable $model)
 * @method static Component              get(string $feature)
 * @method static Manager                image(string $image)
 * @method static MetaElements           metaElements()
 * @method static Contracts\Metable|null model()
 * @method static Manager                only(...$features)
 * @method static OpenGraph\RichObject   openGraph()
 * @method static Manager                set(array|string $property, string|null $value = null)
 * @method static Manager                title(string $title)
 * @method static TwitterCards\Card      twitterCards()
 */
class Fez extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'fez';
    }
}
