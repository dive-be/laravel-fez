<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Hydratable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Models\MetaData;
use Dive\Fez\OpenGraph\Concerns\StaticFactories;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class OpenGraph extends Container implements Hydratable, Imageable
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

    public function hydrate(MetaData $data): void
    {
        $this->properties = array_merge(
            $this->properties,
            array_merge(array_filter($data->only('description', 'image', 'title')), $data->open_graph ?? []),
        );
    }
}
