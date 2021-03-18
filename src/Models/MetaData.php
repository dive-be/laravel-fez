<?php

namespace Dive\Fez\Models;

use Dive\Fez\Casts\DelimitedCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string|null $description
 * @property string|null $image
 * @property string|null $keywords
 * @property mixed       $metaDataable
 * @property array|null  $open_graph
 * @property string|null $robots
 * @property string      $title
 * @property array|null  $twitter
 */
class MetaData extends Model
{
    protected $casts = [
        'keywords' => DelimitedCast::class,
        'open_graph' => 'array',
        'robots' => DelimitedCast::class,
        'twitter' => 'array',
    ];

    protected $fillable = [
        'description',
        'image',
        'keywords',
        'open_graph',
        'robots',
        'title',
        'twitter',
    ];

    public function metaDataable(): MorphTo
    {
        return $this->morphTo();
    }
}
