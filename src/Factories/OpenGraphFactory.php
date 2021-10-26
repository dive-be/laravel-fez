<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Exceptions\SorryUnknownOpenGraphObjectType;
use Dive\Fez\OpenGraph\Objects\Article;
use Dive\Fez\OpenGraph\Objects\Book;
use Dive\Fez\OpenGraph\Objects\Profile;
use Dive\Fez\OpenGraph\Objects\Website;
use Dive\Fez\OpenGraph\RichObject;
use Dive\Fez\Support\Makeable;
use Illuminate\Contracts\Routing\UrlGenerator;

class OpenGraphFactory
{
    use Makeable;

    public function __construct(
        private array $config,
        private string $locale,
        private UrlGenerator $url,
    ) {}

    public function create(): RichObject
    {
        return $this->newRichObject()
            ->when($image = $this->config['image'],
                fn (RichObject $object) => $object->image($image)
            )->when($description = $this->config['description'],
                fn (RichObject $object) => $object->description($description)
            )->when($siteName = $this->config['site_name'],
                fn (RichObject $object) => $object->siteName($siteName)
            )->when($this->config['url'],
                fn (RichObject $object) => $object->url($this->url->current())
            )->when($locale = $this->config['locale'],
                fn (RichObject $object) => $object->locale($this->locale),
            )->when($locale && ($alternates = $this->config['alternates']),
                fn (RichObject $object) => $object->alternateLocale($alternates),
            );
    }

    private function getClass(string $type): string
    {
        return match ($type) {
            'article' => Article::class,
            'book' => Book::class,
            'profile' => Profile::class,
            'website' => Website::class,
            default => throw SorryUnknownOpenGraphObjectType::make($type),
        };
    }

    private function newRichObject(): RichObject
    {
        return call_user_func([$this->getClass($this->config['type']), 'make']);
    }
}
