<?php

namespace Dive\Fez\Containers;

use Dive\Fez\Formatters\TitleFormatter;
use Dive\Fez\Models\MetaData;
use Dive\Fez\Validators\MetaValidator;
use Illuminate\Support\Arr;

final class Meta extends Container
{
    private array $attributes = ['description', 'keywords', 'robots', 'title'];

    private TitleFormatter $formatter;

    public function __construct(array $defaults, MetaValidator $validator)
    {
        parent::__construct($validator);

        $this->formatter = TitleFormatter::make($defaults['suffix'], $defaults['separator']);
        $this->properties = Arr::only($defaults, $this->attributes);
    }

    public function generate(): string
    {
        $meta = $this->toCollection();
        $title = $this->formatter->format($meta->pull('title'));

        return $meta
            ->map(fn ($content, $name) => '<meta name="'.$name.'" content="'.$content.'" />')
            ->prepend("<title>{$title}</title>")
            ->join(PHP_EOL);
    }

    public function hydrate(MetaData $data): self
    {
        $this->properties = array_merge($this->properties, array_filter($data->only($this->attributes)));

        return $this;
    }

    public function toArray(): array
    {
        return array_filter($this->properties);
    }
}
