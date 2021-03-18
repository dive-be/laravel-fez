<?php

namespace Dive\Fez\Containers;

use Dive\Fez\Formatters\TitleFormatter;
use Dive\Fez\Models\MetaData;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class OpenGraph extends Container
{
    public const PREFIX = 'og';

    private TitleFormatter $formatter;

    private bool $locale;

    private bool $url;

    public function __construct(
        private UrlGenerator $urlGenerator,
        private string $activeLocale,
        array $defaults,
    ) {
        $this->formatter = TitleFormatter::make($defaults['suffix'], $defaults['separator']);
        $this->properties = Arr::except($defaults, ['locale', 'suffix', 'separator', 'url']);
        $this->locale = Arr::get($defaults, 'locale', true);
        $this->url = Arr::get($defaults, 'url', true);
    }

    public function generate(): string
    {
        return $this
            ->toCollection()
            ->when($this->locale, fn ($props) => $props->put('locale', $this->activeLocale))
            ->when($this->url, fn ($props) => $props->put('url', $this->urlGenerator->current()))
            ->map(fn ($content, $prop) => '<meta property="'.self::PREFIX.':'.$prop.'" content="'.$content.'" />')
            ->join(PHP_EOL);
    }

    public function hydrate(MetaData $data): self
    {
        return $this;
    }

    protected function normalizeProperty(string $property): string
    {
        return str_replace(self::PREFIX.':', '', parent::normalizeProperty($property));
    }
}
