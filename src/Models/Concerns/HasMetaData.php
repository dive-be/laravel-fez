<?php declare(strict_types=1);

namespace Dive\Fez\Models\Concerns;

use Dive\Fez\MetaData;
use Dive\Fez\Models\Meta;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;

/**
 * @property \Dive\Fez\Models\Meta|null $meta
 * @property array|null                 $metaDefaults
 */
trait HasMetaData
{
    public function gatherMetaData(): MetaData
    {
        $defaults = Arr::only(array_filter($this->metaDefaults(), 'filled'), ['description', 'image', 'title']);

        if (is_null($meta = $this->meta)) {
            return MetaData::make(...$defaults);
        }

        $data = array_filter($meta->data(), 'filled');

        if (empty($defaults)) {
            return MetaData::make(...$data);
        }

        return MetaData::make(...array_merge($defaults, $data));
    }

    public function meta(): MorphOne
    {
        return $this->morphOne(Meta::class, 'metable');
    }

    protected function metaDefaults(): array
    {
        if (! property_exists($this, 'metaDefaults')) {
            return [];
        }

        return array_map(
            fn (string $attribute) => $this->getAttribute($attribute),
            $this->metaDefaults,
        );
    }
}
