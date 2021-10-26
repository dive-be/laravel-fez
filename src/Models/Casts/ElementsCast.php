<?php declare(strict_types=1);

namespace Dive\Fez\Models\Casts;

use Dive\Fez\Exceptions\SorryInboundCastDisallowed;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Arr;

class ElementsCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return array_filter(Arr::only($attributes, ['title', 'description', 'keywords', 'robots']));
    }

    public function set($model, string $key, $value, array $attributes)
    {
        throw SorryInboundCastDisallowed::make();
    }
}
