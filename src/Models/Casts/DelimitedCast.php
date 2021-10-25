<?php declare(strict_types=1);

namespace Dive\Fez\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DelimitedCast implements CastsAttributes
{
    public const DELIMITER = ',';

    public function get($model, string $key, $value, array $attributes)
    {
        return is_string($value) ? explode(self::DELIMITER, $value) : null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return is_array($value) ? implode(self::DELIMITER, $value) : $value;
    }
}
