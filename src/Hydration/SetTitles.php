<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\Factories\FormatterFactory;
use Dive\Fez\FezManager;

class SetTitles
{
    public function __construct(
        private FezManager $fez,
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
        return FormatterFactory::make(
            $this->fez->config('title'),
        )->create();
    }
}
