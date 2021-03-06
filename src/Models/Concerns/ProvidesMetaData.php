<?php

namespace Dive\Fez\Models\Concerns;

use Dive\Fez\Models\MetaData;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;

/**
 * @property MetaData $metaData
 */
trait ProvidesMetaData
{
    public function getMetaData(): MetaData
    {
        $relation = $this->getRelationValue('metaData');

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

    public function metaData(): MorphOne
    {
        return $this->morphOne(config('fez.models.meta_data'), 'meta_dataable')->withDefault();
    }

    protected function metaDefaultsArray(): array
    {
        return isset($this->metaDefaults) ? $this->metaDefaults : [];
    }
}
