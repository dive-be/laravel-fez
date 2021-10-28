<?php declare(strict_types=1);

namespace Dive\Fez\Models\Concerns;

use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Models\Meta;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;

/**
 * @property Meta       $meta
 * @property array|null $metaDefaults
 */
trait HasMetaData
{
    public function gatherMetaData(): MetaData
    {
        $defaults = Arr::only(array_filter($this->metaDefaults()), ['description', 'image', 'title']);

        if (is_null($relation = $this->meta()->getResults())) {
            return MetaData::make(...$defaults);
        }

        $relation = array_filter($relation->toArray());

        if (empty($defaults)) {
            return MetaData::make(...$relation);
        }

        return MetaData::make(...array_merge($defaults, $relation));
    }

    public function meta(): MorphOne
    {
        return $this->morphOne(MorphOne::getMorphedModel(__FUNCTION__), 'metable');
    }

    protected function metaDefaults(): array
    {
        if (! property_exists($this, __FUNCTION__)) {
            return [];
        }

        return array_map(
            fn (string $attribute) => $this->getAttribute($attribute),
            $this->{__FUNCTION__},
        );
    }
}
