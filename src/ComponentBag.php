<?php declare(strict_types=1);

namespace Dive\Fez;

use Illuminate\Support\Arr;

abstract class ComponentBag extends Component
{
    public function __construct(protected array $components = []) {}

    public function generate(): string
    {
        return $this
            ->collect()
            ->sortBy(static fn (Component $component, int|string $key) => is_numeric($key))
            ->values()
            ->map(static fn (Component $component) => $component->generate())
            ->join(PHP_EOL);
    }

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

    public function toArray(): array
    {
        return $this->components;
    }
}
