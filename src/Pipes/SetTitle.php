<?php

namespace Dive\Fez\Pipes;

use Closure;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\Factories\FormatterFactory;
use Dive\Fez\Fez;
use Illuminate\Contracts\Config\Repository;

class SetTitle
{
    public function __construct(
        private Repository $config,
    ) {}

    public function handle(Fez $fez, Closure $next): Fez
    {
        ['title' => $title] = $fez->model()->gatherMetaData();

        if (is_null($title)) {
            return $next($fez);
        }

        $formatter = FormatterFactory::make($this->config['fez.title'])->create();

        foreach ($this->titleables($fez->features()) as $titleable) {
            $titleable->title($formatter->format($title));
        }

        return $next($fez);
    }

    private function titleables(array $features): array
    {
        return array_filter($features, static fn ($feature) => $feature instanceof Titleable);
    }
}
