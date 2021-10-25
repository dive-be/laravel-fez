<?php declare(strict_types=1);

namespace Dive\Fez\Models;

use Dive\Fez\Models\Casts\DelimitedCast;
use Dive\Fez\Models\Casts\OpenGraphCast;
use Dive\Fez\Models\Casts\TwitterCardsCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string|null                         $description
 * @property string|null                         $image
 * @property string|null                         $keywords
 * @property mixed                               $metable
 * @property \Dive\Fez\OpenGraph\RichObject|null $open_graph
 * @property string|null                         $robots
 * @property string                              $title
 * @property \Dive\Fez\TwitterCards\Card|null    $twitter
 */
class Meta extends Model
{
    protected $casts = [
        'keywords' => DelimitedCast::class,
        'open_graph' => OpenGraphCast::class,
        'robots' => DelimitedCast::class,
        'twitter' => TwitterCardsCast::class,
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
