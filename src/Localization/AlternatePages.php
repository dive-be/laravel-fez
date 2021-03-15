<?php

namespace Dive\Fez\Localization;

use Closure;
use Dive\Fez\Component;
use Dive\Fez\Exceptions\TooFewLocalesSpecifiedException;
use Dive\Fez\Exceptions\UnspecifiedAlternateUrlResolverException;
use Illuminate\Http\Request;

final class AlternatePages extends Component
{
    private static ?Closure $resolveAlternateUrlUsing = null;

    public function __construct(private array $locales, private Request $request)
    {
        if (count($locales) < 2) {
            throw TooFewLocalesSpecifiedException::make();
        }
    }

    public static function make(array $locales, Request $request): self
    {
        return new self($locales, $request);
    }

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
