<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Generable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Exceptions\SorryPropertyNotFound;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @property \Dive\Fez\AlternatePage $alternatePage
 * @property \Dive\Fez\Meta          $meta
 * @property \Dive\Fez\OpenGraph     $openGraph
 * @property \Dive\Fez\TwitterCards  $twitterCards
 */
final class Fez extends Component
{
    private array $propertyMapping = [
        'description' => Container::class,
        'image' => Imageable::class,
        'title' => Container::class,
    ];

    public function __construct(private array $components) {}

    public function generate(): string
    {
        return Collection::make(array_values($this->components))
            ->map(fn (Generable $component) => $component->generate())
            ->join(PHP_EOL . PHP_EOL);
    }

    public function get(string $component): ?Component
    {
        return Arr::get($this->components, $component);
    }

    public function set(array|string $property, $value = null): self
    {
        if (empty($property)) {
            return $this;
        }

        if (is_string($property)) {
            $property = [$property => $value];
        }

        $properties = Arr::only($property, array_keys($this->propertyMapping));

        foreach ($this->components as $component) {
            foreach ($properties as $property => $value) {
                if ($component instanceof $this->propertyMapping[$property]) {
                    $component->setProperty($property, $value);
                }
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return array_combine(
            array_keys($this->components),
            array_map(fn (Arrayable $component) => $component->toArray(), $this->components),
        );
    }

    public function __get(string $name): Component
    {
        return tap($this->get($name), static function ($value) use ($name) {
            if (! $value instanceof Component) {
                throw SorryPropertyNotFound::make($name);
            }
        });
    }
}
