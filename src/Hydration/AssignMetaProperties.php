<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Feature;
use Dive\Fez\FezManager;
use Dive\Fez\MetaElements;

class AssignMetaProperties
{
    public function handle(FezManager $fez, Closure $next): FezManager
    {
        if (
            ! $fez->has(Feature::metaElements())
            || empty($source = $fez->metaData()->elements())
        ) {
            return $next($fez);
        }

        $this->assign($fez->metaElements, $source);

        return $next($fez);
    }

    private function assign(MetaElements $meta, array $source)
    {
        foreach ($source as $el) {
            if ($el['type'] === 'element') {
                $meta->{$el['attributes']['name']}($el['attributes']['content']);
            } else {
                $meta->{$el['type']}(...$el['attributes']);
            }
        }
    }
}
