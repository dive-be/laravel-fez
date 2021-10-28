<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Exceptions\SorryNoFeaturesActive;
use Dive\Fez\Exceptions\SorryPropertyNotFound;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;

/**
 * @property \Dive\Fez\AlternatePage        $alternatePage
 * @property \Dive\Fez\MetaElements         $metaElements
 * @property \Dive\Fez\OpenGraph\RichObject $openGraph
 * @property \Dive\Fez\TwitterCards\Card    $twitterCards
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

    public function for(Metable $model): self
    {
        $this->metaData = $model->gatherMetaData();

        return HydrationPipeline::run($this);
    }

    public function features(): array
    {
        return $this->features;
    }

    public function generate(): string
    {
        return Collection::make($this->features)
            ->map(static fn (Component $feature) => $feature->generate())
            ->values()
            ->filter()
            ->join(PHP_EOL . PHP_EOL);
    }

    public function metaData(): MetaData
    {
        return $this->metaData ?? MetaData::make();
    }

    public function toArray(): array
    {
        return array_map(static fn (Component $feature) => $feature->toArray(), $this->features);
    }

    public function __get(string $name): Component
    {
        if (! array_key_exists($name, $this->features)) {
            throw SorryPropertyNotFound::make($name);
        }

        return $this->features[$name];
    }
}
