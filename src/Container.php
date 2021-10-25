<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Generable;
use Illuminate\Support\Arr;

abstract class Container extends Component
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

    public function getProperty(string $name): ?Component
    {
        return Arr::get($this->properties, $name);
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    protected function pushProperties(array $properties): static
    {
        foreach ($properties as $property) {
            $this->pushProperty($property);
        }

        return $this;
    }

    protected function pushProperty(Component $value): static
    {
        if (! empty($value)) {
            $this->properties[] = $value;
        }

        return $this;
    }

    protected function setProperty(string $name, Component $value): static
    {
        if (! empty($value)) {
            Arr::set($this->properties, $name, $value);
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->properties;
    }
}
