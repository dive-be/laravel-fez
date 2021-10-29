<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\Factories\FormatterFactory;
use Dive\Fez\FezManager;
use Illuminate\Contracts\Config\Repository;

class SetTitles
{
    public function __construct(
        private Repository $config,
    ) {}

    public function handle(FezManager $fez, Closure $next): FezManager
    {
        if (is_null($title = $fez->metaData()->title())) {
            return $next($fez);
        }

        $title = $this->createFormatter()->format($title);

        $fez->features()
            ->filter(static fn ($feature) => $feature instanceof Titleable)
            ->each(static fn (Titleable $feature) => $feature->title($title));

        return $next($fez);
    }

    private function createFormatter(): Formatter
    {
        return FormatterFactory::make(
            $this->config['fez.title']
        )->create();
    }
}
