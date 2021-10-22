<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Generable;
use Dive\Fez\Contracts\Hydratable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Contracts\Metable;
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
    private bool $hydrated = false;

    private array $propertyMapping = [
        'description' => Container::class,
        'image' => Imageable::class,
        'title' => Container::class,
    ];

    public function __construct(private Finder $finder, private array $components) {}

    public function generate(): string
    {
        $this->hydrateIfNecessary();

        return Collection::make(array_values($this->components))
            ->map(fn (Generable $component) => $component->generate())
            ->join(PHP_EOL . PHP_EOL);
    }

    public function get(string $component): ?Component
    {
        $this->hydrateIfNecessary();

        return Arr::get($this->components, $component);
    }

    public function set(array|string $property, $value = null): self
    {
        if (empty($property)) {
            return $this;
        }

        $this->hydrateIfNecessary();

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
        $this->hydrateIfNecessary();

        return array_combine(
            array_keys($this->components),
            array_map(fn (Arrayable $component) => $component->toArray(), $this->components),
        );
    }

    private function hydrateIfNecessary(): void
    {
        if ($this->hydrated) {
            return;
        }

        $this->finder->whenFound(function (Metable $metable) {
            $metaData = $metable->getMetaData();

            foreach ($this->components as $component) {
                if ($component instanceof Hydratable) {
                    $component->hydrate($metaData);
                }
            }
        });

        $this->hydrated = true;
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
