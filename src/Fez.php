<?php declare(strict_types=1);

namespace Dive\Fez;

use Illuminate\Support\Collection;

final class Fez extends Component
{
    public function __construct(
        private array $components,
    ) {}

    public function generate(): string
    {
        return Collection::make($this->components)
            ->map(static fn (Component $component) => $component->generate())
            ->values()
            ->filter()
            ->join(PHP_EOL . PHP_EOL);
    }

    public function toArray(): array
    {
        return array_map(static fn (Component $component) => $component->toArray(), $this->components);
    }
}
