<?php

namespace Dive\Fez\Components;

use Dive\Fez\Container;
use Dive\Fez\Contracts\Hydratable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Models\MetaData;
use Dive\Fez\TitleFormatter;

final class TwitterCards extends Container implements Hydratable, Imageable
{
    public const PREFIX = 'twitter';

    public function __construct(private TitleFormatter $formatter, array $defaults)
    {
        parent::__construct($defaults);
    }

    public function generate(): string
    {
        return $this
            ->toCollection()
            ->map(fn ($content, $prop) => $prop === 'title' ? $this->formatter->format($content) : $content)
            ->map(fn ($content, $name) => '<meta name="'.self::PREFIX.':'.$name.'" content="'.$content.'" />')
            ->join(PHP_EOL);
    }

    public function hydrate(MetaData $data): void
    {
        $this->properties = array_merge(
            $this->properties,
            array_merge(array_filter($data->only('description', 'image', 'title')), $data->twitter ?? []),
        );
    }

    protected function normalizeProperty(string $property): string
    {
        return str_replace(self::PREFIX.':', '', parent::normalizeProperty($property));
    }
}
