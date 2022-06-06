<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Dive\Fez\MetaData;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class HydrationPipeline extends Pipeline
{
    protected static array $mapping = [
        'description' => SetDescriptions::class,
        'image' => SetImages::class,
        'title' => SetTitles::class,
    ];

    protected $pipes = [
        SetDescriptions::class,
        SetImages::class,
        SetTitles::class,
        AssignTwitterProperties::class,
        AssignOpenGraphProperties::class,
        AssignMetaProperties::class,
    ];

    public static function has(string $property): bool
    {
        return array_key_exists($property, static::$mapping);
    }

    public static function properties(): array
    {
        return array_keys(static::$mapping);
    }

    public static function run(MetaData $data, ?array $only = null)
    {
        $pipeline = App::make(static::class)->send($data);

        if (is_array($only)) {
            $pipeline->through(Arr::only(static::$mapping, $only));
        }

        $pipeline->thenReturn();
    }
}
