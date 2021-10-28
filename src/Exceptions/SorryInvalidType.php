<?php declare(strict_types=1);

namespace Dive\Fez\Exceptions;

use TypeError;

/**
 * @method static self string(mixed $value)
 */
class SorryInvalidType extends TypeError
{
    public static function __callStatic(string $name, array $arguments)
    {
        [$value] = $arguments;

        return new self("The provided value `{$value}` is not a {$name}.");
    }
}
