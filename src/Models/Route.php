<?php declare(strict_types=1);

namespace Dive\Fez\Models;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Database\Factories\RouteFactory;
use Dive\Fez\Models\Concerns\HasMetaData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Route extends Model implements Metable
{
    use HasFactory;
    use HasMetaData;
    use Prunable;

    protected $casts = [
        'id' => 'integer',
    ];

    protected $guarded = ['id'];

    protected $table = 'routes';

    public $timestamps = false;

    protected static function newFactory(): RouteFactory
    {
        return RouteFactory::new();
    }

    protected function pruning()
    {
        $this->meta?->prune();
    }
}
