<?php

namespace Dive\Fez\Containers;

use ArrayAccess;
use Dive\Fez\Component;
use Dive\Fez\Concerns\Makeable;
use Dive\Fez\Contracts\Hydratable;
use Illuminate\Support\Arr;

abstract class Container extends Component implements ArrayAccess, Hydratable
{
    use Makeable;

    protected array $properties = [];

    public function getProperty(string $property, ?string $default = null)
    {
        return Arr::get($this->properties, $property, $default);
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @throws \Dive\Fez\Exceptions\ValidationException
     */
    public function setProperty(string $property, $value): static
    {
        $property = $this->normalizeProperty($property);

        if (! empty($property) && ! empty($value)) {
            Arr::set($this->properties, $property, $value);
        }

        return $this;
    }

    protected function normalizeProperty(string $property): string
    {
        return trim($property);
    }

    public function offsetExists($offset): bool
    {
        return Arr::has($this->properties, $offset);
    }

    public function offsetGet($offset)
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

    public function __call(string $method, array $arguments)
    {
        if (empty($arguments)) {
            return $this->getProperty($method);
        }

        return $this->setProperty($method, Arr::get($arguments, 0, ''));
    }

    public function __get(string $name)
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
