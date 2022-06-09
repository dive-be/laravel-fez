<?php declare(strict_types=1);

namespace Dive\Fez\Events;

use Dive\Fez\Contracts\Metable;
use Dive\Utils\Makeable;

class MetableWasFound
{
    use Makeable;

    public function __construct(
        public readonly Metable $model,
    ) {}
}
