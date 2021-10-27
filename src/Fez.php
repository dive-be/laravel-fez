<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Exceptions\SorryNoFeaturesActive;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;

class Fez extends Component
{
    use Conditionable;

    public function __construct(
        private array $components,
    ) {
        if (empty($this->components)) {
            throw SorryNoFeaturesActive::make();
        }
    }

    public function for(?Metable $metable): self
    {
        return $this;
    }

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
