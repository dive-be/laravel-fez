<?php declare(strict_types=1);

namespace Tests\Fakes\Models;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Models\Concerns\HasMetaData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Fakes\Factories\PostFactory;

class Post extends Model implements Metable
{
    use HasFactory;
    use HasMetaData;

    protected $table = 'posts';

    public $timestamps = false;

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
