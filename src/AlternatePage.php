<?php declare(strict_types=1);

namespace Dive\Fez;

use Closure;
use Dive\Fez\Exceptions\SorryTooFewLocalesSpecified;
use Dive\Fez\Exceptions\SorryUnspecifiedUrlResolver;
use Illuminate\Http\Request;

final class AlternatePage extends Component
{
    private static ?Closure $urlUsing = null;

    public function __construct(private array $locales, private Request $request)
    {
        if (count($locales) < 2) {
            throw SorryTooFewLocalesSpecified::make();
        }
    }

    public static function urlUsing(Closure $callback): void
    {
        self::$urlUsing = $callback;
    }

    public function generate(): string
    {
        return $this->collect()->map(static function (string $href, string $lang) {
            return "<link rel='alternate' href='{$href}' hreflang='{$lang}' />";
        })->join(PHP_EOL);
    }

    public function toArray(): array
    {
        return array_combine($this->locales, array_map($this->urlResolver(), $this->locales));
    }

    /**
     * @throws SorryUnspecifiedUrlResolver
     */
    private function urlResolver(): Closure
    {
        if (is_null($resolver = self::$urlUsing)) {
            throw SorryUnspecifiedUrlResolver::make();
        }

        return fn (string $locale) => $resolver($locale, $this->request);
    }
}
