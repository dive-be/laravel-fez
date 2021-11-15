<?php declare(strict_types=1);

namespace Dive\Fez\Models;

use Dive\Fez\Database\Factories\MetaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
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
    use HasFactory;
    use Prunable;

    protected $casts = [
        'elements' => 'array',
        'open_graph' => 'array',
        'twitter' => 'array',
    ];

    protected $guarded = ['id'];

    protected $table = 'meta';

    protected static function newFactory(): MetaFactory
    {
        return MetaFactory::new();
    }

    public function data(): array
    {
        return $this->only([
            'description',
            'elements',
            'image',
            'open_graph',
            'title',
            'twitter',
        ]);
    }

    public function metable(): MorphTo
    {
        return $this->morphTo();
    }
}
