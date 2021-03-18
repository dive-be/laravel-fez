<?php

namespace Dive\Fez\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DelimitedCast implements CastsAttributes
{
    public const DELIMITER = ',';

    public function get($model, string $key, $value, array $attributes)
    {
        return explode(self::DELIMITER, $value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return is_array($value) ? implode(self::DELIMITER, $value) : $value;
    }
}
