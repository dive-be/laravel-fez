<?php

namespace Dive\Fez;

use ArrayAccess;
use Dive\Fez\Contracts\Generable;
use Dive\Fez\Exceptions\SorryBadMethodCall;
use Dive\Fez\Exceptions\SorryPropertyNotFound;
use Illuminate\Support\Arr;

abstract class Container extends Component implements ArrayAccess
{
    public function __construct(protected array $properties = []) {}

    public function generate(): string
    {
        return $this
            ->collect()
            ->sortBy(static fn ($prop, $key) => is_numeric($key))
            ->values()
            ->map(static fn (Generable $prop) => $prop->generate())
            ->join(PHP_EOL);
    }

    public function getProperty(string $property, ?string $default = null)
    {
        return Arr::get($this->properties, $property, $default);
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function pushProperties(array $properties): static
    {
        foreach ($properties as $property) {
            $this->pushProperty($property);
        }

        return $this;
    }

    public function pushProperty($value): static
    {
        if (! empty($value)) {
            $this->properties[] = $value;
        }

        return $this;
    }

    public function setProperty(string $name, $value): static
    {
        $name = $this->normalizeName($name);

        if (! empty($name) && ! empty($value)) {
            Arr::set($this->properties, $name, $value);
        }

        return $this;
    }

    protected function normalizeName(string $value): string
    {
        return trim($value);
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

    public function toArray(): array
    {
        return array_filter($this->properties);
    }

    public function __call(string $method, array $arguments)
    {
        if (count($arguments)) {
            return $this->setProperty($method, Arr::get($arguments, 0, ''));
        }

        return tap($this->getProperty($method), static function ($value) use ($method) {
            if (is_null($value)) {
                throw SorryBadMethodCall::make(static::class, $method);
            }
        });
    }

    public function __get(string $name)
    {
        return tap($this->getProperty($name), static function ($value) use ($name) {
            if (is_null($value)) {
                throw SorryPropertyNotFound::make($name);
            }
        });
    }

    public function __isset(string $key): bool
    {
        return $this->offsetExists($key);
    }

    public function __set(string $name, $value): void
    {
        $this->setProperty($name, $value);
    }

    public function __unset(string $key): void
    {
        $this->offsetUnset($key);
    }
}
