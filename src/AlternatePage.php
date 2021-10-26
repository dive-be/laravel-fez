<?php declare(strict_types=1);

namespace Dive\Fez;

use Closure;
use Dive\Fez\Exceptions\SorryTooFewLocalesSpecified;
use Dive\Fez\Exceptions\SorryUnspecifiedUrlResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class AlternatePage extends Component
{
    private static ?Closure $urlUsing = null;

    public function __construct(
        private array $locales,
        private Request $request,
    ) {
        if (count($locales) < 2) {
            throw SorryTooFewLocalesSpecified::make();
        }
    }

    public static function urlUsing(Closure $callback): void
    {
        self::$urlUsing = $callback;
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

    private function tag(string $href, string $lang): string
    {
        return <<<HTML
<link rel="alternate" href="{$href}" hreflang="{$lang}" />
HTML;
    }

    public function generate(): string
    {
        return Collection::make($this->toArray())
            ->map(fn (string $href, string $lang) => $this->tag($href, $lang))
            ->join(PHP_EOL);
    }

    public function toArray(): array
    {
        return array_combine($this->locales, array_map($this->urlResolver(), $this->locales));
    }
}
