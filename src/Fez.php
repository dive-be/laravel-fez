<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Generable;
use Dive\Fez\Contracts\Hydratable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Contracts\Metaable;
use Dive\Fez\Exceptions\NoFeaturesActiveException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @property \Dive\Fez\AlternatePage|null $alternatePage
 * @property \Dive\Fez\Meta|null          $meta
 * @property \Dive\Fez\OpenGraph|null     $openGraph
 * @property \Dive\Fez\TwitterCards|null  $twitterCards
 */
final class Fez extends Component
{
    private array $components;

    private bool $hydrated = false;

    private array $propertyMapping = [
        'description' => Container::class,
        'image' => Imageable::class,
        'title' => Container::class,
    ];

    public function __construct(
        private ComponentFactory $factory,
        private MetaableFinder $finder,
    ) {
        $this->components = $this->initialize();
    }

    public function generate(): string
    {
        $this->hydrateIfNecessary();

        return Collection::make(array_values($this->components))
            ->map(fn (Generable $component) => $component->generate())
            ->join(PHP_EOL.PHP_EOL);
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

    public function use(Metaable $metaable): self
    {
        $this->finder->alwaysFind($metaable);

        if ($this->hydrated) {
            $this->components = $this->initialize();

            $this->hydrated = false;
        }

        return $this;
    }

    private function hydrateIfNecessary(): void
    {
        if ($this->hydrated) {
            return;
        }

        $this->finder->whenFound(function (Metaable $metaable) {
            $metaData = $metaable->getMetaData();

            foreach ($this->components as $component) {
                if ($component instanceof Hydratable) {
                    $component->hydrate($metaData);
                }
            }
        });

        $this->hydrated = true;
    }

    /**
     * @throws NoFeaturesActiveException
     */
    private function initialize(): array
    {
        if (empty($features = Feature::enabled())) {
            throw NoFeaturesActiveException::make();
        }

        return array_combine($features, array_map([$this->factory, 'make'], $features));
    }

    public function __get(string $name): ?Component
    {
        return $this->get($name);
    }
}
