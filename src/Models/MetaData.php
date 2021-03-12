<?php

namespace Dive\Fez\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string|null $description
 * @property string|null $image
 * @property string|null $keywords
 * @property string|null $robots
 * @property string $title
 */
class MetaData extends Model
{
    protected $guarded = [];

    public function metaDataable(): MorphTo
    {
        return $this->morphTo();
    }
}
