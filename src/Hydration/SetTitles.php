<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Factories\FormatterFactory;
use Dive\Fez\Manager;
use Illuminate\Contracts\Config\Repository;

class SetTitles
{
    public function __construct(
        private Repository $config,
        private Manager $fez,
    ) {}

    public function handle(MetaData $data, Closure $next): MetaData
    {
        if (is_null($title = $data->title())) {
            return $next($data);
        }

        $features = $this->fez
            ->features()
            ->filter(static fn ($feature) => $feature instanceof Titleable);

        if ($features->isEmpty()) {
            return $next($data);
        }

        $title = $this->createFormatter()->format($title);

        $features->each(static fn (Titleable $feature) => $feature->title($title));

        return $next($data);
    }

    private function createFormatter(): Formatter
    {
        return FormatterFactory::make()->create($this->config->get('fez.title'));
    }
}
