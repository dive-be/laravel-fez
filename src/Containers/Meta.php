<?php

namespace Dive\Fez\Containers;

use Dive\Fez\Models\MetaData;

final class Meta extends Container
{
    public function generate(): string
    {
        return $this
            ->toCollection()
            ->map(fn ($content, $name) => '<meta name="'.$name.'" content="'.$content.'" />')
            ->join(PHP_EOL);
    }

    public function hydrate(MetaData $data): self
    {
        return $this;
    }

    public function toArray(): array
    {
        return [
            'description' => 'The guest list and parade of limousines with celebrities',
            'robots' => 'index, follow',
        ];
    }
}
