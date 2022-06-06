<?php declare(strict_types=1);

namespace Dive\Fez\DataTransferObjects;

use Dive\Utils\Makeable;

class MetaData
{
    use Makeable;

    public function __construct(
        private ?string $description = null,
        private ?array $elements = null,
        private ?string $image = null,
        private ?array $open_graph = null,
        private ?string $title = null,
        private ?array $twitter = null,
    ) {}

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
