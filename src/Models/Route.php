<?php declare(strict_types=1);

namespace Dive\Fez\Models;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Models\Concerns\HasMetaData;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $description
 * @property string      $name
 */
class Route extends Model implements Metable
{
    use HasMetaData;

    protected $guarded = ['id'];
}
