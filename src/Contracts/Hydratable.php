<?php

namespace Dive\Fez\Contracts;

use Dive\Fez\Models\Meta;

interface Hydratable
{
    public function hydrate(Meta $meta): void;
}
