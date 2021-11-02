<?php declare(strict_types=1);

namespace Dive\Fez\Factories\Feature;

use Dive\Fez\MetaElements;
use Dive\Fez\Support\Makeable;
use Illuminate\Contracts\Routing\UrlGenerator;

class MetaElementsFactory
{
    use Makeable;

    public function __construct(
        private UrlGenerator $url,
    ) {}

    public function create(array $config): MetaElements
    {
        return MetaElements::make()
            ->when($description = $config['description'],
                static fn (MetaElements $meta) => $meta->description($description)
            )->when($config['canonical'],
                fn (MetaElements $meta) => $meta->canonical($this->url->current())
            )->when($keywords = $config['keywords'],
                static fn (MetaElements $meta) => $meta->keywords($keywords)
            )->when($robots = $config['robots'],
                static fn (MetaElements $meta) => $meta->robots($robots)
            );
    }
}
