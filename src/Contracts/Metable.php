<?php declare(strict_types=1);

namespace Dive\Fez\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Metable
{
    public function gatherMetaData(): array;

    public function meta(): MorphOne;
}
