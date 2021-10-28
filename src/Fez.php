<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Exceptions\SorryBadMethodCall;
use Dive\Fez\Exceptions\SorryNoFeaturesActive;
use Dive\Fez\Exceptions\SorryPropertyNotFound;
use Dive\Fez\Exceptions\SorryUnknownFeature;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;

/**
 * @method AlternatePage        alternatePage()
 * @method MetaElements         metaElements()
 * @method OpenGraph\RichObject openGraph()
 * @method TwitterCards\Card    twitterCards()
 *
 * @property AlternatePage        $alternatePage
 * @property MetaElements         $metaElements
 * @property OpenGraph\RichObject $openGraph
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
        if ($this->doesntExist($feature)) {
            throw SorryUnknownFeature::make($feature);
        }

        return $this->features[$feature];
    }

    public function metaData(): MetaData
    {
        return $this->metaData ?? MetaData::make();
    }

    public function toArray(): array
    {
        return array_map(static fn (Component $feature) => $feature->toArray(), $this->features);
    }

    private function doesntExist(string $feature)
    {
        return ! array_key_exists($feature, $this->features);
    }

    public function __call(string $name, array $arguments): Component
    {
        if (count($arguments) || $this->doesntExist($name)) {
            throw SorryBadMethodCall::make(static::class, $name);
        }

        return $this->get($name);
    }

    public function __get(string $name): Component
    {
        if ($this->doesntExist($name)) {
            throw SorryPropertyNotFound::make(static::class, $name);
        }

        return $this->get($name);
    }
}
