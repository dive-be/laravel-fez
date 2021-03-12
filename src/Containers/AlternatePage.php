<?php

namespace Dive\Fez\Containers;

final class AlternatePage extends Container
{
    public function generate(): string
    {
        return $this
            ->toCollection()
            ->map(fn ($href, $lang) => '<link rel="alternate" href="'.$href.'" hreflang="'.$lang.'" />')
            ->join(PHP_EOL);
    }

    public function toArray(): array
    {
        return [
            'en' => 'https://dive.be/en',
            'nl' => 'https://dive.be/nl',
        ];
    }
}
