<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Feature;
use Dive\Fez\Manager;
use Dive\Fez\MetaData;
use Dive\Fez\MetaElements;

class AssignMetaProperties
{
    public function __construct(
        private Manager $fez,
    ) {}

    public function handle(MetaData $data, Closure $next): MetaData
    {
        if (
            ! $this->fez->has(Feature::metaElements())
            || empty($source = $data->elements())
        ) {
            return $next($data);
        }

        $this->assign($this->fez->metaElements, $source);

        return $next($data);
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
