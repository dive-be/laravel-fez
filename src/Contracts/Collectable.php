<?php

namespace Dive\Fez\Contracts;

use Illuminate\Support\Collection;

interface Collectable
{
    public function collect(): Collection;
}
