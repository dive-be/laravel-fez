<?php declare(strict_types=1);

namespace Dive\Fez\Factories\Feature;

use Dive\Fez\Factories\RichObjectFactory;
use Dive\Fez\OpenGraph\RichObject;
use Dive\Fez\Support\Makeable;
use Illuminate\Contracts\Routing\UrlGenerator;

class OpenGraphFactory
{
    use Makeable;

    private RichObjectFactory $factory;

    public function __construct(
        private string $locale,
        private UrlGenerator $url,
    ) {
        $this->factory = RichObjectFactory::make();
    }

    public function create(array $config): RichObject
    {
        return $this->factory->create($config['type'])
            ->when($image = $config['image'],
                static fn (RichObject $object) => $object->image($image)
            )->when($description = $config['description'],
                static fn (RichObject $object) => $object->description($description)
            )->when($siteName = $config['site_name'],
                static fn (RichObject $object) => $object->siteName($siteName)
            )->when($config['url'],
                fn (RichObject $object) => $object->url($this->url->current())
            )->when($locale = $config['locale'],
                fn (RichObject $object) => $object->locale($this->locale),
            )->when($locale && ($alternates = $config['alternates']),
                static fn (RichObject $object) => $object->alternateLocale($alternates),
            );
    }
}
