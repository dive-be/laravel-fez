<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Pipes\SetDescription;
use Dive\Fez\Pipes\SetImage;
use Dive\Fez\Pipes\SetTitle;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\App;

class HydrationPipeline extends Pipeline
{
    protected $pipes = [
        SetDescription::class,
        SetImage::class,
        SetTitle::class,
    ];

    public static function run(Fez $manager): Fez
    {
        return App::make(static::class)->send($manager)->thenReturn();
    }
}