<?php declare(strict_types=1);

namespace Dive\Fez;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;

abstract class Container extends Component
{
    use Conditionable;

    protected array $components = [];

    public function components(): array
    {
        return $this->components;
    }

    public function flush(): static
    {
        $this->components = [];

        return $this;
    }

    public function get(string $name)
    {
        return Arr::get($this->components, $name);
    }

    public function render(): string
    {
        return Collection::make($this->components)
            ->sortBy(static fn (Component $component, int|string $key) => is_numeric($key))
            ->values()
            ->map(static fn (Component $component) => $component->render())
            ->join(PHP_EOL);
    }

    public function toArray(): array
    {
        return array_values(array_map(static fn (Component $component) => $component->toArray(), $this->components));
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
}
