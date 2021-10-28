<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Pipes\SetTitle;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\App;

class HydrateManagerPipeline extends Pipeline
{
    protected $pipes = [
        SetTitle::class,
    ];

    public static function run(Fez $manager): Fez
    {
        return App::make(static::class)->send($manager)->thenReturn();
    }
}
