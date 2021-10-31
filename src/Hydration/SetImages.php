<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\DataTransferObjects\MetaData;
use Dive\Fez\FezManager;

class SetImages
{
    public function __construct(
        private FezManager $fez,
    ) {}

    public function handle(MetaData $data, Closure $next): MetaData
    {
        if (is_null($image = $data->image())) {
            return $next($data);
        }

        $features = $this->fez
            ->features()
            ->filter(static fn ($feature) => $feature instanceof Imageable);

        if ($features->isEmpty()) {
            return $next($data);
        }

        $features->each(static fn (Imageable $feature) => $feature->image($image));

        return $next($data);
    }
}
