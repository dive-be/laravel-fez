<?php

namespace Dive\Fez\Pipes;

use Closure;
use Dive\Fez\Factories\FormatterFactory;
use Dive\Fez\Feature;
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

        foreach ($this->titlables($fez) as $feature) {
            $feature->title($formatter->format($title));
        }

        return $next($fez);
    }

    private function titlables(Fez $fez): array
    {
        return $fez->features(
            Feature::metaElements(),
            Feature::openGraph(),
            Feature::twitterCards(),
        );
    }
}
