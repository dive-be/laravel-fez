<?php

namespace Dive\Fez\Concerns;

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

        if (! is_array($this->metaDefaults) || count($this->metaDefaults) < 1) {
            return $relation;
        }

        [
            $metaAttributes,
            $modelAttributes
        ] = Arr::divide(Arr::only($this->metaDefaults, $relation->getFillable()));

        return $relation->fill(array_merge(
            array_combine($metaAttributes, array_values($this->only($modelAttributes))),
            array_filter($relation->only($relation->getFillable())),
        ));
    }

    public function metaData(): MorphOne
    {
        return $this->morphOne(config('fez.models.meta_data'), 'meta_dataable')->withDefault();
    }
}
