<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Hydratable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Models\MetaData;
use Dive\Fez\TwitterCards\Concerns\StaticFactories;

final class TwitterCards extends Container implements Hydratable, Imageable
{
    use StaticFactories;

    public function __construct(private TitleFormatter $formatter, array $defaults)
    {
        parent::__construct($defaults);
    }

    public function generate(): string
    {
        return $this->collect()->map(function (string $content, string $prop) {
            return $prop === 'title' ? $this->formatter->format($content) : $content;
        })->map(static function (string $content, string $prop) {
            return "<meta property='twitter:{$prop}' content='{$content}' />";
        })->join(PHP_EOL);
    }

    public function hydrate(MetaData $data): void
    {
        $this->properties = array_merge(
            $this->properties,
            array_merge(array_filter($data->only('description', 'image', 'title')), $data->twitter ?? []),
        );
    }
}
