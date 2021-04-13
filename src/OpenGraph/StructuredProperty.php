<?php

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Container;
use Dive\Fez\OpenGraph;
use Illuminate\Support\Str;

abstract class StructuredProperty extends Container
{
    public function setProperty(string $name, $value): static
    {
        $prefix = Str::lower(class_basename(static::class));

        return parent::setProperty($name, Property::make($prefix.OpenGraph::DELIMITER.$name, $value));
    }
}
