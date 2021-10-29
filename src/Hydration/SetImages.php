<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\FezManager;

class SetImages
{
    public function handle(FezManager $fez, Closure $next): FezManager
    {
        if (is_null($image = $fez->metaData()->image())) {
            return $next($fez);
        }

        $fez->features()
            ->filter(static fn ($feature) => $feature instanceof Imageable)
            ->each(static fn (Imageable $feature) => $feature->image($image));

        return $next($fez);
    }
}
