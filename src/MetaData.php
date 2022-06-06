<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Utils\Makeable;

class MetaData
{
    use Makeable;

    public function __construct(
        public readonly ?string $description = null,
        public readonly ?array $elements = null,
        public readonly ?string $image = null,
        public readonly ?array $open_graph = null,
        public readonly ?string $title = null,
        public readonly ?array $twitter = null,
    ) {}

    /**
     * TODO - Remove getters.
     */
    public function description(): ?string
    {
        return $this->description;
    }

    public function elements(): ?array
    {
        return $this->elements;
    }

    public function image(): ?string
    {
        return $this->image;
    }

    public function openGraph(): ?array
    {
        return $this->open_graph;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function twitterCards(): ?array
    {
        return $this->twitter;
    }
}
