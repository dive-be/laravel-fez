<?php

namespace Dive\Fez\Models\Concerns;

use Dive\Fez\Models\MetaData;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;

trait ProvidesMetaData
{
    protected array $metaDefaults = [];

    public function getMetaDataAttribute(): MetaData
    {
        $relation = $this->getRelationValue('metaData');
        [$metaAttributes, $modelAttributes] = Arr::divide($this->metaDefaults);

        return $relation->fill(array_merge(
            array_combine($metaAttributes, array_values($this->only($modelAttributes))),
            array_filter($relation->only(config('fez.allowed_defaults'))),
        ));
    }

    public function metaData(): MorphOne
    {
        return $this->morphOne(MetaData::class, 'meta_dataable')->withDefault();
    }

    protected function initializeProvidesMetaData()
    {
        $this->metaDefaults = Arr::only($this->metaDefaults, config('fez.allowed_defaults'));
    }
}
