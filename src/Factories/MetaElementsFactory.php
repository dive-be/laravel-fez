<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\MetaElements;
use Dive\Fez\Support\Makeable;
use Illuminate\Contracts\Routing\UrlGenerator;

class MetaElementsFactory
{
    use Makeable;

    public function __construct(
        private array $config,
        private UrlGenerator $url,
    ) {}

    public function create(): MetaElements
    {
        return MetaElements::make()
            ->when($description = $this->config['description'],
                fn (MetaElements $meta) => $meta->description($description)
            )->when($this->config['canonical'],
                fn (MetaElements $meta) => $meta->canonical($this->url->current())
            )->when($keywords = $this->config['keywords'],
                fn (MetaElements $meta) => $meta->keywords($keywords)
            )->when($robots = $this->config['robots'],
                fn (MetaElements $meta) => $meta->robots($robots)
            );
    }
}
