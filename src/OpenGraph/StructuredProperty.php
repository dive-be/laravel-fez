<?php

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Container;
use Illuminate\Support\Str;

abstract class StructuredProperty extends Container
{
    public function setProperty(string $name, $value): static
    {
        $prefix = Str::lower(class_basename(static::class));

        return parent::setProperty($name, Property::make($prefix . Property::DELIMITER . $name, $value));
    }
}
