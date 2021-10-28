<?php declare(strict_types=1);

namespace Dive\Fez\Pipes;

use Closure;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Fez;

class SetImage
{
    public function handle(Fez $fez, Closure $next): Fez
    {
        if (is_null($image = $fez->metaData()->image())) {
            return $next($fez);
        }

        foreach ($this->getImageables($fez->features()) as $feature) {
            $feature->image($image);
        }

        return $next($fez);
    }

    private function getImageables(array $features): array
    {
        return array_filter($features, static fn ($feature) => $feature instanceof Imageable);
    }
}
