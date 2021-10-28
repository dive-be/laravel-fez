<?php declare(strict_types=1);

namespace Dive\Fez\DataTransferObjects;

use Dive\Fez\Support\Makeable;

class MetaData
{
    use Makeable;

    public function __construct(
        private ?string $description = null,
        private ?string $image = null,
        private ?string $keywords = null,
        private ?array $open_graph = null,
        private ?string $robots = null,
        private ?string $title = null,
        private ?array $twitter = null,
    ) {}

    public function description(): ?string
    {
        return $this->description;
    }

    public function image(): ?string
    {
        return $this->image;
    }

    public function keywords(): ?string
    {
        return $this->keywords;
    }

    public function openGraph(): ?array
    {
        return $this->open_graph;
    }

    public function robots(): ?string
    {
        return $this->robots;
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
