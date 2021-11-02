<?php declare(strict_types=1);

namespace Tests\Fakes\Models;

use Dive\Fez\Contracts\Metable;
use Dive\Fez\Models\Concerns\HasMetaData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Orchestra\Testbench\Factories\UserFactory;

class User extends Authenticatable implements Metable
{
    use HasFactory;
    use HasMetaData;

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
