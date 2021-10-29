<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Contracts\Describable;
use Dive\Fez\FezManager;
use Illuminate\Support\Str;

class SetDescriptions
{
    public const MAX_LENGTH = 140;

    public function handle(FezManager $fez, Closure $next): FezManager
    {
        if (is_null($description = $fez->metaData()->description())) {
            return $next($fez);
        }

        $features = $fez
            ->features()
            ->filter(static fn ($feature) => $feature instanceof Describable);

        if ($features->isEmpty()) {
            return $next($fez);
        }

        $description = $this->format($description);

        $features->each(static fn (Describable $feature) => $feature->description($description));

        return $next($fez);
    }

    private function format(string $description): string
    {
        return Str::limit($description, self::MAX_LENGTH);
    }
}
