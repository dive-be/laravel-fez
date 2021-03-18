<?php

namespace Dive\Fez\Containers;

use Dive\Fez\Formatters\TitleFormatter;
use Dive\Fez\Models\MetaData;
use Illuminate\Support\Arr;

final class Meta extends Container
{
    private array $attributes = ['description', 'keywords', 'robots', 'title'];

    private TitleFormatter $formatter;

    public function __construct(array $defaults)
    {
        $this->formatter = TitleFormatter::make($defaults['suffix'], $defaults['separator']);
        $this->properties = Arr::only($defaults, $this->attributes);
    }

    public function generate(): string
    {
        $properties = $this->toCollection();
        $title = $this->formatter->format($properties->pull('title'));

        return $properties
            ->map(fn ($content) => is_array($content) ? implode(', ', $content) : $content)
            ->map(fn ($content, $name) => '<meta name="'.$name.'" content="'.$content.'" />')
            ->prepend("<title>{$title}</title>")
            ->join(PHP_EOL);
    }

    public function hydrate(MetaData $data): self
    {
        $this->properties = array_merge($this->properties, array_filter($data->only($this->attributes)));

        return $this;
    }
}
