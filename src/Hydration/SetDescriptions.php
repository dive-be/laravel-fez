<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Contracts\Describable;
use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\FezManager;
use Illuminate\Support\Str;

class SetDescriptions
{
    public const MAX_LENGTH = 140;

    public function __construct(
        private FezManager $fez,
    ) {}

    public function handle(MetaData $data, Closure $next): MetaData
    {
        if (is_null($description = $data->description())) {
            return $next($data);
        }

        $features = $this->fez
            ->features()
            ->filter(static fn ($feature) => $feature instanceof Describable);

        if ($features->isEmpty()) {
            return $next($data);
        }

        $description = $this->format($description);

        $features->each(static fn (Describable $feature) => $feature->description($description));

        return $next($data);
    }

    private function format(string $description): string
    {
        return Str::limit($description, self::MAX_LENGTH);
    }
}
