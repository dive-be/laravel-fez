<?php declare(strict_types=1);

namespace Dive\Fez\Factories\Feature;

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
                static fn (MetaElements $meta) => $meta->description($description)
            )->when($this->config['canonical'],
                fn (MetaElements $meta) => $meta->canonical($this->url->current())
            )->when($keywords = $this->config['keywords'],
                static fn (MetaElements $meta) => $meta->keywords($keywords)
            )->when($robots = $this->config['robots'],
                static fn (MetaElements $meta) => $meta->robots($robots)
            );
    }
}
