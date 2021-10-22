<?php

namespace Dive\Fez\Models\Concerns;

use Dive\Fez\Models\Meta;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;

/**
 * @property Meta       $meta
 * @property array|null $metaDefaults
 */
trait HasMetaData
{
    public function getMetaData(): Meta
    {
        $relation = $this->getRelationValue('meta');

        if (count($this->metaDefaultsArray()) < 1) {
            return $relation;
        }

        [
            $metaAttributes,
            $modelAttributes
        ] = Arr::divide(Arr::only($this->metaDefaultsArray(), $relation->getFillable()));

        return $relation->fill(array_merge(
            array_combine($metaAttributes, array_values($this->only($modelAttributes))),
            array_filter($relation->only($relation->getFillable())),
        ));
    }

    public function meta(): MorphOne
    {
        return $this->morphOne(config('fez.models.meta'), 'metable')->withDefault();
    }

    protected function metaDefaultsArray(): array
    {
        return $this->metaDefaults ?? [];
    }
}
