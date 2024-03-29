<?php declare(strict_types=1);

namespace Dive\Fez;

use Closure;
use Dive\Fez\Exceptions\TooFewLocalesSpecifiedException;
use Dive\Fez\Exceptions\UnspecifiedUrlResolverException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AlternatePage extends Component
{
    private static ?Closure $resolver = null;

    public function __construct(
        private array $locales,
        private Request $request,
    ) {
        if (count($locales) < 2) {
            throw TooFewLocalesSpecifiedException::make();
        }
    }

    public static function resolveUrlsUsing(?Closure $callback)
    {
        self::$resolver = $callback;
    }

    public function locales(): array
    {
        return $this->locales;
    }

    public function render(): string
    {
        return Collection::make($this->toArray())
            ->map(fn (string $href, string $lang) => $this->tag(e($href), e($lang)))
            ->join(PHP_EOL);
    }

    public function toArray(): array
    {
        return array_combine($this->locales, array_map($this->resolver(), $this->locales));
    }

    /**
     * @throws UnspecifiedUrlResolverException
     */
    private function resolver(): Closure
    {
        if (is_null($resolver = self::$resolver)) {
            throw UnspecifiedUrlResolverException::make();
        }

        return fn (string $locale) => $resolver($locale, $this->request);
    }

    private function tag(string $href, string $lang): string
    {
        return <<<HTML
        <link rel="alternate" href="{$href}" hreflang="{$lang}" />
        HTML;
    }
}
