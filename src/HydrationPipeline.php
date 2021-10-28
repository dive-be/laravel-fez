<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Pipes\SetDescription;
use Dive\Fez\Pipes\SetImage;
use Dive\Fez\Pipes\SetTitle;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class HydrationPipeline extends Pipeline
{
    protected static array $mapping = [
        'description' => SetDescription::class,
        'image' => SetImage::class,
        'title' => SetTitle::class,
    ];

    protected $pipes = [
        SetDescription::class,
        SetImage::class,
        SetTitle::class,
    ];

    public static function mappedProperties(): array
    {
        return array_keys(static::$mapping);
    }

    public static function only(Fez $manager, array $only): Fez
    {
        return static::prepare($manager)
            ->through(Arr::only(static::$mapping, $only))
            ->thenReturn();
    }

    public static function run(Fez $manager): Fez
    {
        return static::prepare($manager)->thenReturn();
    }

    private static function prepare(Fez $manager): self
    {
        return App::make(static::class)->send($manager);
    }
}
