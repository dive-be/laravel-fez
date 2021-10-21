<?php

namespace Dive\Fez;

use Closure;
use Dive\Fez\Exceptions\SorryTooFewLocalesSpecified;
use Dive\Fez\Exceptions\SorryUnspecifiedUrlResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Traits\Localizable;

final class AlternatePage extends Component
{
    use Localizable;

    private static ?Closure $url = null;

    public function __construct(private array $locales, private Request $request)
    {
        if (count($locales) < 2) {
            throw SorryTooFewLocalesSpecified::make();
        }
    }

    public static function urlUsing(Closure $callback): void
    {
        self::$url = $callback;
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
        if (is_null($resolver = self::$url)) {
            throw SorryUnspecifiedUrlResolver::make();
        }

        return fn (string $locale) => $this->withLocale($locale, fn () => $resolver($this->request));
    }
}
