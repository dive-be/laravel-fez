<?php

namespace Dive\Fez\Contracts;

use Dive\Fez\Models\MetaData;

interface Hydratable
{
    public function hydrate(MetaData $data): self;
}
