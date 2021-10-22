<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Imageable;
use Dive\Fez\OpenGraph\Concerns\StaticFactories;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class OpenGraph extends Container implements Imageable
{
    use StaticFactories;

    private bool $locale;

    private bool $url;

    public function __construct(
        private TitleFormatter $formatter,
        private UrlGenerator $urlGenerator,
        private string $activeLocale,
        array $defaults,
    ) {
        $this->locale = Arr::pull($defaults, 'locale', true);
        $this->url = Arr::pull($defaults, 'url', true);

        parent::__construct($defaults);
    }

    public function generate(): string
    {
        return $this->collect()->map(function (string $content, string $prop) {
            return $prop === 'title' ? $this->formatter->format($content) : $content;
        })->when($this->locale, function (Collection $props) {
            return $props->put('locale', $this->activeLocale);
        })->when($this->url, function (Collection $props) {
            return $props->put('url', $this->urlGenerator->current());
        })->map(static function (string $content, string $prop) {
            return "<meta property='og:{$prop}' content='{$content}' />";
        })->join(PHP_EOL);
    }
}
