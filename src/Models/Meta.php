<?php declare(strict_types=1);

namespace Dive\Fez\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string|null $description
 * @property array       $elements
 * @property string|null $image
 * @property mixed       $metable
 * @property array|null  $open_graph
 * @property string      $title
 * @property array|null  $twitter
 */
class Meta extends Model
{
    protected $casts = [
        'elements' => 'array',
        'open_graph' => 'array',
        'twitter' => 'array',
    ];

    protected $guarded = ['id'];

    protected $visible = [
        'description',
        'elements',
        'image',
        'open_graph',
        'title',
        'twitter',
    ];

    protected $table = 'meta';

    public function metable(): MorphTo
    {
        return $this->morphTo();
    }
}
