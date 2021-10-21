<?php

namespace Dive\Fez;

use Closure;
use Dive\Fez\Exceptions\TooFewLocalesSpecifiedException;
use Dive\Fez\Exceptions\UnspecifiedAlternateUrlResolverException;
use Illuminate\Http\Request;

final class AlternatePage extends Component
{
    private static ?Closure $resolveAlternateUrlUsing = null;

    public function __construct(private array $locales, private Request $request)
    {
        if (count($locales) < 2) {
            throw TooFewLocalesSpecifiedException::make();
        }
    }

    public static function resolveAlternateUrlUsing(Closure $callback): void
    {
        self::$resolveAlternateUrlUsing = $callback;
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
     * @throws UnspecifiedAlternateUrlResolverException
     */
    private function resolveAlternateUrl(): Closure
    {
        return is_null($resolver = self::$resolveAlternateUrlUsing)
            ? throw UnspecifiedAlternateUrlResolverException::make()
            : $resolver;
    }
}
