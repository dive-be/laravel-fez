<?php declare(strict_types=1);

namespace Dive\Fez\Loaders;

use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Contracts\Loader;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\Manager;
use Dive\Fez\MetaData;

class TitleLoader implements Loader
{
    public function __construct(
        private Formatter $formatter,
    ) {}

    public function load(Manager $fez, MetaData $data)
    {
        if (is_null($data->title)) {
            return;
        }

        $title = $this->formatter->format($data->title);

        $fez->features()
            ->filter(static fn ($feature) => $feature instanceof Titleable)
            ->each(static fn (Titleable $feature) => $feature->title($title));
    }
}
