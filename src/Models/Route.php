<?php declare(strict_types=1);

namespace Dive\Fez\Models;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Database\Factories\RouteFactory;
use Dive\Fez\Models\Concerns\HasMetaData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model implements Metable
{
    use HasFactory;
    use HasMetaData;

    protected $table = 'routes';

    protected $guarded = ['id'];

    public $timestamps = false;

    protected static function newFactory(): RouteFactory
    {
        return RouteFactory::new();
    }
}
