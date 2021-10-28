<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Exceptions\SorryBadMethodCall;
use Dive\Fez\Exceptions\SorryInvalidType;
use Dive\Fez\Exceptions\SorryNoFeaturesActive;
use Dive\Fez\Exceptions\SorryPropertyNotFound;
use Dive\Fez\Exceptions\SorryUnknownFeature;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;

/**
 * @method AlternatePage        alternatePage()
 * @method Fez                  description(string $description)
 * @method Fez                  image(string $image)
 * @method MetaElements         metaElements()
 * @method OpenGraph\RichObject openGraph()
 * @method Fez                  title(string $title)
 * @method TwitterCards\Card    twitterCards()
 *
 * @property AlternatePage        $alternatePage
 * @property-write string         $description
 * @property-write string         $image
 * @property MetaElements         $metaElements
 * @property OpenGraph\RichObject $openGraph
 * @property-write string         $title
 * @property TwitterCards\Card    $twitterCards
 */
class Fez extends Component
{
    use Conditionable;

    private MetaData $metaData;

    public function __construct(
        private array $features,
    ) {
        if (empty($this->features)) {
            throw SorryNoFeaturesActive::make();
        }
    }

    public function features(): array
    {
        return $this->features;
    }

    public function flush(): self
    {
        foreach ($this->features as $feature) {
            $feature?->flush();
        }

        return $this;
    }

    public function for(Metable $model): self
    {
        $this->metaData = $model->gatherMetaData();

        return HydrationPipeline::run($this);
    }

    public function generate(): string
    {
        return Collection::make($this->features)
            ->map(static fn (Component $feature) => $feature->generate())
            ->values()
            ->filter()
            ->join(PHP_EOL . PHP_EOL);
    }

    public function get(string $feature): Component
    {
        if ($this->doesntHaveFeature($feature)) {
            throw SorryUnknownFeature::make($feature);
        }

        return $this->features[$feature];
    }

    public function metaData(): MetaData
    {
        return $this->metaData ?? MetaData::make();
    }

    public function set(array|string $property, $value = null): self
    {
        if (is_string($property)) {
            $property = [$property => $value];
        }

        $properties = Arr::only($property, HydrationPipeline::properties());

        if (empty($properties)) {
            return $this;
        }

        return $this->hydrateOnly($properties);
    }

    public function toArray(): array
    {
        return array_map(static fn (Component $feature) => $feature->toArray(), $this->features);
    }

    private function doesntHaveFeature(string $feature): bool
    {
        return ! array_key_exists($feature, $this->features);
    }

    private function doesntHaveProperty(string $property): bool
    {
        return ! in_array($property, HydrationPipeline::properties());
    }

    private function hydrateOnly(array|string $key, ?string $value = null): self
    {
        if (is_string($key)) {
            $key = [$key => $value];
        }

        $this->metaData = new MetaData(...$key);

        HydrationPipeline::only($this, array_keys($key));

        return $this;
    }

    public function __call(string $name, array $arguments): Component|self
    {
        if (empty($arguments)) {
            if ($this->doesntHaveFeature($name)) {
                throw SorryBadMethodCall::make(static::class, $name);
            }

            return $this->get($name);
        }

        if (count($arguments) > 1 || $this->doesntHaveProperty($name)) {
            throw SorryBadMethodCall::make(static::class, $name);
        }

        if (! is_string($value = $arguments[0])) {
            throw SorryInvalidType::string($value);
        }

        return $this->hydrateOnly($name, $value);
    }

    public function __get(string $name): Component
    {
        if ($this->doesntHaveFeature($name)) {
            throw SorryPropertyNotFound::make(static::class, $name);
        }

        return $this->get($name);
    }

    public function __set(string $name, $value)
    {
        if ($this->doesntHaveProperty($name)) {
            throw SorryPropertyNotFound::make(static::class, $name);
        }

        if (! is_string($value)) {
            throw SorryInvalidType::string($value);
        }

        $this->hydrateOnly($name, $value);
    }
}
