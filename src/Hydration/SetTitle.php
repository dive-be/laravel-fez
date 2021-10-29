<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\Factories\FormatterFactory;
use Dive\Fez\FezManager;
use Illuminate\Contracts\Config\Repository;

class SetTitle
{
    public function __construct(
        private Repository $config,
    ) {}

    public function handle(FezManager $fez, Closure $next): FezManager
    {
        if (is_null($title = $fez->metaData()->title())) {
            return $next($fez);
        }

        $formatter = FormatterFactory::make(
            $this->config['fez.title']
        )->create();

        foreach ($this->getTitleables($fez->features()) as $feature) {
            $feature->title($formatter->format($title));
        }

        return $next($fez);
    }

    private function getTitleables(array $features): array
    {
        return array_filter($features, static fn ($feature) => $feature instanceof Titleable);
    }
}
