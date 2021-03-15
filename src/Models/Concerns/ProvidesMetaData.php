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
    protected array $metaDefaults = [];

    public function getMetaData(): MetaData
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
        return $this->morphOne(config('fez.models.meta_data'), 'meta_dataable')->withDefault();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return tap(parent::resolveRouteBinding($value, $field), function ($model) {
            app('fez')->use($model);
        });
    }

    protected function initializeProvidesMetaData()
    {
        $this->metaDefaults = Arr::only($this->metaDefaults, config('fez.allowed_defaults'));
    }
}
