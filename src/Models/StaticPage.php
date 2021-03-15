<?php

namespace Dive\Fez\Models;

use Dive\Fez\Contracts\Metaable;
use Dive\Fez\Models\Concerns\ProvidesMetaData;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $description
 * @property string      $key
 * @property string|null $name
 */
class StaticPage extends Model implements Metaable
{
    use ProvidesMetaData;

    protected $guarded = [];
}
