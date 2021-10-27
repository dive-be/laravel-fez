<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Exceptions\SorryNoFeaturesActive;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;

class Fez extends Component
{
    use Conditionable;

    private Metable $model;

    public function __construct(
        private array $features,
    ) {
        if (empty($this->features)) {
            throw SorryNoFeaturesActive::make();
        }
    }

    public function for(?Metable $model): self
    {
        if (is_null($model)) {
            return $this;
        }

        $this->model = $model;

        return HydrateManagerPipeline::run($this);
    }

    public function features(string ...$only): array
    {
        return empty($only) ? $this->features : Arr::only($this->features, $only);
    }

    public function generate(): string
    {
        return Collection::make($this->features)
            ->map(static fn (Component $feature) => $feature->generate())
            ->values()
            ->filter()
            ->join(PHP_EOL . PHP_EOL);
    }

    public function model(): Metable
    {
        return $this->model;
    }

    public function toArray(): array
    {
        return array_map(static fn (Component $feature) => $feature->toArray(), $this->features);
    }
}
