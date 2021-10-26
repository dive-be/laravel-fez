<?php declare(strict_types=1);

namespace Dive\Fez;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class ComponentBag extends Component
{
    protected array $components = [];

    public function get(string $name): ?Component
    {
        return Arr::get($this->components, $name);
    }

    public function getComponents(): array
    {
        return $this->components;
    }

    protected function pushMany(array $components): static
    {
        foreach ($components as $component) {
            $this->push($component);
        }

        return $this;
    }

    protected function push(Component $component): static
    {
        if (! empty($component)) {
            $this->components[] = $component;
        }

        return $this;
    }

    protected function set(string $name, Component $component): static
    {
        if (! empty($component)) {
            Arr::set($this->components, $name, $component);
        }

        return $this;
    }

    public function generate(): string
    {
        return Collection::make($this->components)
            ->sortBy(static fn (Component $component, int|string $key) => is_numeric($key))
            ->values()
            ->map(static fn (Component $component) => $component->generate())
            ->join(PHP_EOL);
    }

    public function toArray(): array
    {
        return array_map(static fn (Component $component) => $component->toArray(), $this->components);
    }
}
