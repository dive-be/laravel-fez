<?php declare(strict_types=1);

namespace Dive\Fez;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Manager|AlternatePage        alternatePage(AlternatePage|null $alternatePage)
 * @method static Manager                      description(string $description)
 * @method static Manager                      except(string ...$features)
 * @method static Component                    get(string $feature)
 * @method static Manager                      image(string $image)
 * @method static Manager                      loadFrom(Contracts\Metable $model)
 * @method static Manager|MetaElements         metaElements(MetaElements|null $metaElements)
 * @method static Manager                      only(string ...$features)
 * @method static Manager|OpenGraph\RichObject openGraph(OpenGraph\RichObject|null $richObject)
 * @method static Manager                      set(array|string $property, string|null $value = null)
 * @method static Manager                      title(string $title)
 * @method static Manager|TwitterCards\Card    twitterCards(TwitterCards\Card|null $card)
 *
 * @see Manager
 */
class Fez extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'fez';
    }
}
