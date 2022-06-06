<?php declare(strict_types=1);

namespace Dive\Fez\Loaders;

use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Contracts\Loader;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\Factories\FormatterFactory;
use Dive\Fez\Manager;
use Dive\Fez\MetaData;
use Illuminate\Contracts\Config\Repository;

class TitleLoader implements Loader
{
    public function __construct(
        private Repository $config,
    ) {}

    public function load(Manager $fez, MetaData $data)
    {
        if (is_null($data->title)) {
            return;
        }

        $title = $this->createFormatter()->format($data->title);

        $fez->features()
            ->filter(static fn ($feature) => $feature instanceof Titleable)
            ->each(static fn (Titleable $feature) => $feature->title($title));
    }

    private function createFormatter(): Formatter
    {
        return FormatterFactory::make()->create($this->config->get('fez.title'));
    }
}
