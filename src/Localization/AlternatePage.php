<?php

namespace Dive\Fez\Localization;

use Closure;
use Dive\Fez\Composite;
use Dive\Fez\Exceptions\TooFewLocalesSpecifiedException;
use Dive\Fez\Exceptions\UnspecifiedAlternateUrlResolverException;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

final class AlternatePage extends Composite
{
    private static ?Closure $resolveAlternateUrlUsing = null;

    public function __construct(private Repository $config, private Request $request) {}

    public static function resolveAlternateUrlUsing(Closure $callback): void
    {
        self::$resolveAlternateUrlUsing = $callback;
    }

    public function generate(): string
    {
        return $this
            ->toCollection()
            ->map(fn ($href, $lang) => '<link rel="alternate" href="'.$href.'" hreflang="'.$lang.'" />')
            ->join(PHP_EOL);
    }

    public function toArray(): array
    {
        $locales = $this->resolveLocales();
        $urlResolver = $this->resolveAlternateUrl();

        return array_combine(
            $locales,
            array_map(fn ($locale) => $urlResolver($locale, $this->request), $locales)
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

    /**
     * @throws TooFewLocalesSpecifiedException
     */
    private function resolveLocales(): array
    {
        $locales = array_unique($this->config->get('fez.locales'));

        if (count($locales) < 2) {
            throw TooFewLocalesSpecifiedException::make();
        }

        return $locales;
    }
}
