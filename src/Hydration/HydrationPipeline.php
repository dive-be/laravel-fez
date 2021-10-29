<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Dive\Fez\FezManager;
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

    public static function properties(): array
    {
        return array_keys(static::$mapping);
    }

    public static function run(FezManager $fez, ?array $only = null): FezManager
    {
        return tap(App::make(static::class)->send($fez), static function (self $pipeline) use ($only) {
            if (is_array($only)) {
                $pipeline->through(Arr::only(static::$mapping, $only));
            }
        })->thenReturn();
    }
}
