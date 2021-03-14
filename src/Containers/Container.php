<?php

namespace Dive\Fez\Containers;

use ArrayAccess;
use Dive\Fez\Component;
use Illuminate\Support\Arr;

abstract class Container extends Component implements ArrayAccess
{
    final public function __construct(protected array $properties = []) {}

    public static function make(array $properties = []): static
    {
        return new static($properties);
    }

    public function getProperty(string $property, ?string $default = null): ?string
    {
        return Arr::get($this->properties, $property, $default);
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function setProperty(string $property, string $value): static
    {
        if (! empty($value)) {
            Arr::set($this->properties, $property, $value);
        }

        return $this;
    }

    public function offsetExists($offset): bool
    {
        return Arr::has($this->properties, $offset);
    }

    public function offsetGet($offset): ?string
    {
        return $this->getProperty($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->setProperty($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        Arr::forget($this->properties, $offset);
    }

    public function __call(string $method, array $arguments): static|string|null
    {
        if (empty($arguments)) {
            return $this->getProperty($method);
        }

        return $this->setProperty($method, Arr::get($arguments, 0, ''));
    }

    public function __get(string $name): ?string
    {
        return $this->getProperty($name);
    }

    public function __isset(string $key): bool
    {
        return $this->offsetExists($key);
    }

    public function __set(string $name, string $value): void
    {
        $this->setProperty($name, $value);
    }

    public function __unset(string $key): void
    {
        $this->offsetUnset($key);
    }
}
