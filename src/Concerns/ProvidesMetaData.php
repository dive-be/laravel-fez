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
        return $this->getRelationValue('metaData');
    }

    public function metaData(): MorphOne
    {
        return $this->morphOne(config('fez.models.meta_data'), 'meta_dataable')->withDefault();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return tap(
            parent::resolveRouteBinding($value, $field),
            fn ($model) => $model->exists && app('fez')->use($model),
        );
    }
}
