<?php

namespace Dive\Fez\Contracts;

use Dive\Fez\Models\MetaData;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Metaable
{
    public function getMetaDataAttribute(): MetaData;

    public function metaData(): MorphOne;
}
