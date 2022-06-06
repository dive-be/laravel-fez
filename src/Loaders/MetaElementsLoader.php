<?php declare(strict_types=1);

namespace Dive\Fez\Loaders;

use Dive\Fez\Contracts\Loader;
use Dive\Fez\Feature;
use Dive\Fez\Manager;
use Dive\Fez\MetaData;
use Dive\Fez\MetaElements;

class MetaElementsLoader implements Loader
{
    public function load(Manager $fez, MetaData $data)
    {
        if (! $fez->has(Feature::metaElements())) {
            return;
        }

        $source = $data->elements;

        if (empty($source)) {
            return;
        }

        $this->assign($fez->metaElements, $source);
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
