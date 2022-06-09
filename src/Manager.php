<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Exceptions\BadMethodCallException;
use Dive\Fez\Exceptions\PropertyNotFoundException;
use Dive\Fez\Exceptions\UnknownFeatureException;
use Illuminate\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @method Manager|AlternatePage        alternatePage(AlternatePage|null $alternatePage)
 * @method Manager                      description(string $description)
 * @method Manager                      image(string $image)
 * @method Manager|MetaElements         metaElements(MetaElements|null $metaElements)
 * @method Manager|OpenGraph\RichObject openGraph(OpenGraph\RichObject|null $richObject)
 * @method Manager                      title(string $title)
 * @method Manager|TwitterCards\Card    twitterCards(TwitterCards\Card|null $card)
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
    private Collection $features;

    private array $loaders = [
        'description' => \Dive\Fez\Loaders\DescriptionLoader::class,
        'image' => \Dive\Fez\Loaders\ImageLoader::class,
        'title' => \Dive\Fez\Loaders\TitleLoader::class,
        \Dive\Fez\Loaders\TwitterCardsLoader::class,
        \Dive\Fez\Loaders\OpenGraphLoader::class,
        \Dive\Fez\Loaders\MetaElementsLoader::class,
    ];

    public function __construct(array $features)
    {
        $this->features = Collection::make($features);
    }

    public function assign(string $name, Component $feature): self
    {
        if (! $this->has($name)) {
            throw UnknownFeatureException::make($name);
        }

        $this->features->put($name, $feature);

        return $this;
    }

    public function except(string ...$features): self
    {
        return tap(clone $this, function (self $that) use ($features) {
            $that->features = $this->features->except($features);
        });
    }

    public function features(): Collection
    {
        return $this->features;
    }

    public function flush(): self
    {
        foreach ($this->features as $feature) {
            method_exists($feature, 'clear') && $feature->clear();
        }

        return $this;
    }

    /**
     * @throws UnknownFeatureException
     */
    public function get(string $feature): Component
    {
        if (! $this->has($feature)) {
            throw UnknownFeatureException::make($feature);
        }

        return $this->features->get($feature);
    }

    public function has(string $feature): bool
    {
        return $this->features->has($feature);
    }

    public function loadFrom(Metable $model): self
    {
        return $this->load($model->gatherMetaData());
    }

    public function only(string ...$features): self
    {
        return tap(clone $this, function (self $that) use ($features) {
            $that->features = $this->features->only($features);
        });
    }

    public function render(): string
    {
        return $this->features
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
        return $this->features->toArray();
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

        if (count($arguments) > 1 || ! array_key_exists($name, $this->loaders) && ! $this->has($name)) {
            throw BadMethodCallException::make(static::class, $name);
        }

        return $this->has($name)
            ? $this->assign($name, $arguments[0])
            : $this->set($name, $arguments[0]);
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
