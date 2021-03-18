<?php

namespace Dive\Fez\Containers;

use Dive\Fez\Formatters\TitleFormatter;
use Dive\Fez\Models\MetaData;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;

final class OpenGraph extends Container
{
    public const PREFIX = 'og';

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
        $this->properties = $defaults;
    }

    public function generate(): string
    {
        return $this
            ->toCollection()
            ->map(fn ($content, $prop) => $prop === 'title' ? $this->formatter->format($content) : $content)
            ->when($this->locale, fn ($props) => $props->put('locale', $this->activeLocale))
            ->when($this->url, fn ($props) => $props->put('url', $this->urlGenerator->current()))
            ->map(fn ($content, $prop) => '<meta property="'.self::PREFIX.':'.$prop.'" content="'.$content.'" />')
            ->join(PHP_EOL);
    }

    public function hydrate(MetaData $data): void
    {
        $this->properties = array_merge(
            $this->properties,
            array_merge(array_filter($data->only('description', 'image', 'title')), $data->open_graph ?? []),
        );
    }

    protected function normalizeProperty(string $property): string
    {
        return str_replace(self::PREFIX.':', '', parent::normalizeProperty($property));
    }
}
