<?php declare(strict_types=1);

namespace Dive\Fez\Loaders;

use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Contracts\Loader;
use Dive\Fez\Manager;
use Dive\Fez\MetaData;

class ImageLoader implements Loader
{
    public function load(Manager $fez, MetaData $data)
    {
        if (is_null($data->image)) {
            return;
        }

        $fez->features()
            ->filter(static fn ($feature) => $feature instanceof Imageable)
            ->each(static fn (Imageable $feature) => $feature->image($data->image));
    }
}
