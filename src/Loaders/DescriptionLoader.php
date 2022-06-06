<?php declare(strict_types=1);

namespace Dive\Fez\Loaders;

use Dive\Fez\Contracts\Describable;
use Dive\Fez\Contracts\Loader;
use Dive\Fez\Manager;
use Dive\Fez\MetaData;

class DescriptionLoader implements Loader
{
    public function load(Manager $fez, MetaData $data)
    {
        if (is_null($data->description)) {
            return;
        }

        $fez->features()
            ->filter(static fn ($feature) => $feature instanceof Describable)
            ->each(static fn (Describable $feature) => $feature->description($data->description));
    }
}
