<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Generable;
use Dive\Fez\Contracts\Hydratable;
use Dive\Fez\Contracts\Metaable;
use Dive\Fez\Exceptions\NoFeaturesActiveException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use ReflectionClass;

/**
 * @property \Dive\Fez\Localization\AlternatePages|null $alternatePages
 * @property \Dive\Fez\Containers\Meta|null             $meta
 * @property \Dive\Fez\Containers\OpenGraph|null        $openGraph
 * @property \Dive\Fez\Containers\Schema|null           $schemaOrg
 * @property \Dive\Fez\Containers\TwitterCards|null     $twitterCards
 */
final class Fez extends Component
{
    public const FEATURE_ALTERNATE_PAGES = 'alternatePages';
    public const FEATURE_META = 'meta';
    public const FEATURE_OPEN_GRAPH = 'openGraph';
    public const FEATURE_SCHEMA_ORG = 'schemaOrg';
    public const FEATURE_TWITTER_CARDS = 'twitterCards';

    private array $components;

    private ?Metaable $metaable = null;

    private bool $hydrated = false;

    public function __construct(private array $features, private ComponentFactory $factory)
    {
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

    public function toArray(): array
    {
        $this->hydrateIfNecessary();

        return array_combine(
            array_keys($this->components),
            array_map(fn (Arrayable $component) => $component->toArray(), $this->components),
        );
    }

    public function use(Metaable $metaable): void
    {
        $this->metaable = $metaable;

        if ($this->hydrated) {
            $this->components = $this->initialize();

            $this->hydrated = false;
        }
    }

    private function hydrateIfNecessary(): void
    {
        if ($this->hydrated) {
            return;
        }

        if (is_null($this->metaable)) {
            return;
        }

        $metaData = $this->metaable->getMetaData();

        foreach ($this->components as $component) {
            if ($component instanceof Hydratable) {
                $component->hydrate($metaData);
            }
        }

        $this->hydrated = true;
    }

    /**
     * @throws NoFeaturesActiveException
     */
    private function initialize(): array
    {
        $features = array_intersect($this->features, (new ReflectionClass(self::class))->getConstants());

        if (empty($features)) {
            throw NoFeaturesActiveException::make();
        }

        return array_combine($features, array_map([$this->factory, 'make'], $features));
    }

    public function __get(string $name): ?Component
    {
        return $this->get($name);
    }
}
