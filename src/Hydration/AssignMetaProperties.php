<?php

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\FezManager;

class AssignMetaProperties
{
    public function handle(FezManager $fez, Closure $next): FezManager
    {
        $data = $fez->metaData();

        if (is_string($keywords = $data->keywords())) {
            $fez->metaElements->keywords($keywords);
        }

        if (is_string($robots = $data->robots())) {
            $fez->metaElements->robots($robots);
        }

        return $next($fez);
    }
}
