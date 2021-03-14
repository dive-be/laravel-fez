<?php

namespace Dive\Fez\Containers;

final class TwitterCards extends Container
{
    public const PREFIX = 'twitter';

    public function generate(): string
    {
        return $this
            ->toCollection()
            ->map(fn ($content, $name) => '<meta name="'.self::PREFIX.':'.$name.'" content="'.$content.'" />')
            ->join(PHP_EOL);
    }

    public function toArray(): array
    {
        return [
            'card' => 'summary_large_image',
            'creator' => '@diveHQ',
            'description' => 'The guest list and parade of limousines with celebrities',
            'site' => '@dive',
            'title' => 'Brands to dive for',
        ];
    }
}
