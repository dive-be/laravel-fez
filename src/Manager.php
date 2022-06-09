<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Exceptions\BadMethodCallException;
use Dive\Fez\Exceptions\NoFeaturesActiveException;
use Dive\Fez\Exceptions\PropertyNotFoundException;
use Dive\Fez\Exceptions\UnknownFeatureException;
use Illuminate\Container\Container;
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
    private array $loaders = [
        'description' => \Dive\Fez\Loaders\DescriptionLoader::class,
        'image' => \Dive\Fez\Loaders\ImageLoader::class,
        'title' => \Dive\Fez\Loaders\TitleLoader::class,
        \Dive\Fez\Loaders\TwitterCardsLoader::class,
        \Dive\Fez\Loaders\OpenGraphLoader::class,
        \Dive\Fez\Loaders\MetaElementsLoader::class,
    ];

    private ?Metable $model = null;

    public function __construct(
        private array $features,
    ) {}

    public function assign(string $name, Component $feature): self
    {
        if (! $this->has($name)) {
            throw UnknownFeatureException::make($name);
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

    public function get(string $feature): Component
    {
        if (! $this->has($feature)) {
            throw UnknownFeatureException::make($feature);
        }

        return $this->features[$feature];
    }

    public function has(string $feature): bool
    {
        return array_key_exists($feature, $this->features);
    }

    public function loadFrom(Metable $model): self
    {
        $this->model = $model;

        return $this->load($model->gatherMetaData());
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

        $property = Arr::only($property, array_keys($this->loaders));

        return $this->load(new MetaData(...$property));
    }

    public function toArray(): array
    {
        return array_map(static fn (Component $feature) => $feature->toArray(), $this->features);
    }

    private function load(MetaData $data): self
    {
        foreach ($this->loaders as $loader) {
            Container::getInstance()->make($loader)->load($this, $data);
        }

        return $this;
    }

    public function __call(string $name, array $arguments): Component|self
    {
        if (empty($arguments)) {
            if (! $this->has($name)) {
                throw BadMethodCallException::make(static::class, $name);
            }

            return $this->get($name);
        }

        if (count($arguments) > 1 || ! array_key_exists($name, $this->loaders)) {
            throw BadMethodCallException::make(static::class, $name);
        }

        return $this->set($name, $arguments[0]);
    }

    public function __get(string $name): Component
    {
        if (! $this->has($name)) {
            throw PropertyNotFoundException::make(static::class, $name);
        }

        return $this->get($name);
    }

    public function __set(string $name, $value)
    {
        if (! array_key_exists($name, $this->loaders) && ! $this->has($name)) {
            throw PropertyNotFoundException::make(static::class, $name);
        }

        if ($this->has($name)) {
            $this->assign($name, $value);
        } else {
            $this->set($name, $value);
        }
    }
}
