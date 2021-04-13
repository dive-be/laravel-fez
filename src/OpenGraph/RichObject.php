<?php

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Container;
use Dive\Fez\OpenGraph\Structures\Audio;
use Dive\Fez\OpenGraph\Structures\Image;
use Dive\Fez\OpenGraph\Structures\Video;
use Illuminate\Support\Str;

abstract class RichObject extends Container
{
    public function __construct(array|string $properties = [])
    {
        if (is_string($properties)) {
            $properties = ['title' => $properties];
        }

        parent::__construct($properties + ['type' => Str::lower(class_basename(static::class))]);
    }

    public function alternateLocale(string $alternateLocale): static
    {
        return $this->pushProperty($alternateLocale);
    }

    public function audio(Audio|string $audio): static
    {
        return $this->pushProperty($audio);
    }

    public function description(string $description): static
    {
        return $this->setProperty(__FUNCTION__, $description);
    }

    public function determiner(string $determiner): static
    {
        return $this->setProperty(__FUNCTION__, $determiner);
    }

    public function image(Image|string $image): static
    {
        return $this->pushProperty($image);
    }

    public function locale(string $locale): static
    {
        return $this->setProperty(__FUNCTION__, $locale);
    }

    public function siteName(string $siteName): static
    {
        return $this->setProperty(__FUNCTION__, $siteName);
    }

    public function title(string $title): static
    {
        return $this->setProperty(__FUNCTION__, $title);
    }

    public function url(string $url): static
    {
        return $this->setProperty(__FUNCTION__, $url);
    }

    public function video(Video|string $video): static
    {
        return $this->pushProperty($video);
    }
}
