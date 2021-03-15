<?php

namespace Dive\Fez\Containers;

use Dive\Fez\Models\MetaData;

final class OpenGraph extends Container
{
    public const PREFIX = 'og';

    public function generate(): string
    {
        return $this
            ->toCollection()
            ->map(fn ($content, $prop) => '<meta property="'.self::PREFIX.':'.$prop.'" content="'.$content.'" />')
            ->join(PHP_EOL);
    }

    public function hydrate(MetaData $data): self
    {
        return $this;
    }

    public function toArray(): array
    {
        return [
            'image' => 'https://static.dive.be/images/og.jpg',
            'locale' => 'en',
            'site_name' => 'DIVE',
            'type' => 'website',
            'url' => 'https://dive.be',
        ];
    }
}
