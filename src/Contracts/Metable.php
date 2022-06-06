<?php declare(strict_types=1);

namespace Dive\Fez\Contracts;

use Dive\Fez\MetaData;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Metable
{
    public function gatherMetaData(): MetaData;

    public function getKey();

    public function getMorphClass();

    public function meta(): MorphOne;
}
