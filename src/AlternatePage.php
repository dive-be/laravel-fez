<?php

namespace Dive\Fez;

use Closure;
use Dive\Fez\Exceptions\SorryTooFewLocalesSpecified;
use Dive\Fez\Exceptions\SorryUnspecifiedUrlResolver;
use Illuminate\Http\Request;

final class AlternatePage extends Component
{
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
        $urlResolver = $this->resolveAlternateUrl();

        return array_combine(
            $this->locales,
            array_map(fn ($locale) => $urlResolver($locale, $this->request), $this->locales)
        );
    }

    /**
     * @throws SorryUnspecifiedUrlResolver
     */
    private function resolveAlternateUrl(): Closure
    {
        return is_null($resolver = self::$url) ? throw SorryUnspecifiedUrlResolver::make() : $resolver;
    }
}
