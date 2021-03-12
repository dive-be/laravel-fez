<?php

namespace Dive\Fez\Containers;

use Dive\Fez\Contracts\Collectable;
use Dive\Fez\Contracts\Generable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use ArrayAccess;
use JsonSerializable;
use Stringable;

abstract class Container implements
    Arrayable,
    ArrayAccess,
    Collectable,
    Generable,
    Htmlable,
    Jsonable,
    JsonSerializable,
    Stringable
{
    public function __construct(protected array $properties = []) {}

    public static function make(array $properties = []): static
    {
        return new static($properties);
    }

    abstract public function generate(): string;

    abstract public function toArray(): array;

    public function getProperty(string $property, string $default = null)
    {
        return Arr::get($this->properties, $property, $default);
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function setProperty(string $property, string $value)
    {
        if (! empty($value)) {
            Arr::set($this->properties, $property, $value);
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toCollection(): Collection
    {
        return Collection::make($this->toArray());
    }

    public function toHtml()
    {
        return $this->generate();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function offsetExists($offset)
    {
        return Arr::has($this->properties, $offset);
    }

    public function offsetGet($offset)
    {
        return $this->getProperty($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->setProperty($offset, $value);
    }

    public function offsetUnset($offset)
    {
        Arr::forget($this->properties, $offset);
    }

    public function __call(string $method, array $arguments)
    {
        return $this->setProperty($method, Arr::get($arguments, 0, ''));
    }

    public function __toString(): string
    {
        return $this->generate();
    }
}
