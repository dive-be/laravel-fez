<?php

namespace Dive\Fez\Models;

use Dive\Fez\Models\Casts\DelimitedCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string|null $description
 * @property string|null $image
 * @property string|null $keywords
 * @property mixed       $metable
 * @property array|null  $open_graph
 * @property string|null $robots
 * @property string      $title
 * @property array|null  $twitter
 */
class Meta extends Model
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

    protected $table = 'meta';

    public function metable(): MorphTo
    {
        return $this->morphTo();
    }
}
