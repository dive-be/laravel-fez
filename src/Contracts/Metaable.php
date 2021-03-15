<?php

namespace Dive\Fez\Contracts;

use Dive\Fez\Models\MetaData;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Metaable
{
    public function getMetaData(): MetaData;

    public function metaData(): MorphOne;
}
