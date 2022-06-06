<?php declare(strict_types=1);

namespace Dive\Fez;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Dive\Fez\Exceptions\BadMethodCallException;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;
use IteratorAggregate;

abstract class Container extends Component implements ArrayAccess, Countable, IteratorAggregate
{
    use Conditionable;

    protected array $components = [];

    public function clear(): static
    {
        $this->components = [];

        return $this;
    }

    public function components(): array
    {
        return $this->components;
    }

    public function get(int|string $name): ?Component
    {
        return $this->components[$name] ?? null;
    }

    public function has(int|string $name): bool
    {
        return array_key_exists($name, $this->components);
    }

    public function pushMany(array $components): static
    {
        foreach ($components as $component) {
            $this->push($component);
        }

        return $this;
    }

    public function push(Component $component): static
    {
        $this->components[] = $component;

        return $this;
    }

    public function remove(int|string $name): static
    {
        unset($this->components[$name]);

        return $this;
    }

    public function render(): string
    {
        return Collection::make($this->components)
            ->sortBy(static fn (Component $component, int|string $key) => is_numeric($key))
            ->values()
            ->map(static fn (Component $component) => $component->render())
            ->join(PHP_EOL);
    }

    public function set(string $name, Component $component): static
    {
        $this->components[$name] = $component;

        return $this;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->components);
    }

    public function count(): int
    {
        return count($this->components);
    }

    public function toArray(): array
    {
        return array_values(
            array_map(static fn (Component $component) => $component->toArray(), $this->components)
        );
    }

    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset): ?Component
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }

    public function __call(string $name, array $arguments): Component|static
    {
        if (! count($arguments)) {
            if (! $this->has($name)) {
                throw BadMethodCallException::make(static::class, $name);
            }

            return $this->get($name);
        }

        if (count($arguments) > 1) {
            throw BadMethodCallException::make(static::class, $name);
        }

        return $this->set($name, $arguments[0]);
    }

    public function __get(string $name): ?Component
    {
        return $this->get($name);
    }

    public function __set(string $name, $value)
    {
        $this->set($name, $value);
    }
}
