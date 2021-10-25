<?php declare(strict_types=1);

namespace Dive\Fez\Contracts;

use Dive\Fez\Models\Meta;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Metable
{
    public function getMetaData(): Meta;

    public function meta(): MorphOne;
}
