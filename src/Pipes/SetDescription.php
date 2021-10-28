<?php declare(strict_types=1);

namespace Dive\Fez\Pipes;

use Closure;
use Dive\Fez\Contracts\Describable;
use Dive\Fez\FezManager;
use Illuminate\Support\Str;

class SetDescription
{
    public const MAX_LENGTH = 140;

    public function handle(FezManager $fez, Closure $next): FezManager
    {
        if (is_null($description = $fez->metaData()->description())) {
            return $next($fez);
        }

        $description = $this->format($description);

        foreach ($this->getDescribables($fez->features()) as $feature) {
            $feature->description($description);
        }

        return $next($fez);
    }

    private function format(string $description): string
    {
        return Str::limit($description, self::MAX_LENGTH);
    }

    private function getDescribables(array $features): array
    {
        return array_filter($features, static fn ($feature) => $feature instanceof Describable);
    }
}
