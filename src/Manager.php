<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Exceptions\SorryBadMethodCall;
use Dive\Fez\Exceptions\SorryNoFeaturesActive;
use Dive\Fez\Exceptions\SorryPropertyNotFound;
use Dive\Fez\Exceptions\SorryUnknownFeature;
use Dive\Fez\Hydration\HydrationPipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @method AlternatePage        alternatePage()
 * @method Manager              description(string $description)
 * @method Manager              image(string $image)
 * @method MetaElements         metaElements()
 * @method OpenGraph\RichObject openGraph()
 * @method Manager              title(string $title)
 * @method TwitterCards\Card    twitterCards()
 *
 * @property AlternatePage        $alternatePage
 * @property string               $description
 * @property string               $image
 * @property MetaElements         $metaElements
 * @property OpenGraph\RichObject $openGraph
 * @property string               $title
 * @property TwitterCards\Card    $twitterCards
 */
class Manager extends Component
{
    private ?Metable $model = null;

    public function __construct(
        private array $features,
    ) {
        if (empty($this->features)) {
            throw SorryNoFeaturesActive::make();
        }
    }

    public function assign(string $name, Component $feature): self
    {
        if (! $this->has($name)) {
            throw SorryUnknownFeature::make($name);
        }

        $this->features[$name] = $feature;

        return $this;
    }

    public function except(...$features): self
    {
        return tap(clone $this, function (self $that) use ($features) {
            $that->features = Arr::except($this->features, $features);
        });
    }

    public function features(): Collection
    {
        return Collection::make($this->features);
    }

    public function flush(): self
    {
        foreach ($this->features as $feature) {
            method_exists($feature, 'clear') && $feature->clear();
        }

        return $this;
    }

    public function for(Metable $model): self
    {
        $this->model = $model;

        HydrationPipeline::run($model->gatherMetaData());

        return $this;
    }

    public function get(string $feature): Component
    {
        if (! $this->has($feature)) {
            throw SorryUnknownFeature::make($feature);
        }

        return $this->features[$feature];
    }

    public function has(string $feature): bool
    {
        return array_key_exists($feature, $this->features);
    }

    public function model(): ?Metable
    {
        return $this->model;
    }

    public function only(...$features): self
    {
        return tap(clone $this, function (self $that) use ($features) {
            $that->features = Arr::only($this->features, $features);
        });
    }

    public function render(): string
    {
        return $this
            ->features()
            ->map(static fn (Component $feature) => $feature->render())
            ->values()
            ->filter()
            ->join(PHP_EOL . PHP_EOL);
    }

    public function set(array|string $property, ?string $value = null): self
    {
        if (is_string($property)) {
            $property = [$property => $value];
        }

        $property = Arr::only($property, HydrationPipeline::properties());

        HydrationPipeline::run(new MetaData(...$property), array_keys($property));

        return $this;
    }

    public function toArray(): array
    {
        return array_map(static fn (Component $feature) => $feature->toArray(), $this->features);
    }

    public function __call(string $name, array $arguments): Component|self
    {
        if (empty($arguments)) {
            if (! $this->has($name)) {
                throw SorryBadMethodCall::make(static::class, $name);
            }

            return $this->get($name);
        }

        if (count($arguments) > 1 || ! HydrationPipeline::has($name)) {
            throw SorryBadMethodCall::make(static::class, $name);
        }

        return $this->set($name, $arguments[0]);
    }

    public function __get(string $name): Component
    {
        if (! $this->has($name)) {
            throw SorryPropertyNotFound::make(static::class, $name);
        }

        return $this->get($name);
    }

    public function __set(string $name, $value)
    {
        if (! HydrationPipeline::has($name) && ! $this->has($name)) {
            throw SorryPropertyNotFound::make(static::class, $name);
        }

        if ($this->has($name)) {
            $this->assign($name, $value);
        } else {
            $this->set($name, $value);
        }
    }
}
