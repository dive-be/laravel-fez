<?php

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Container;
use Illuminate\Support\Str;

abstract class RichObject extends Container
{
    public function __construct(array $properties = [])
    {
        parent::__construct($properties + ['type' => Str::lower(class_basename(static::class))]);
    }

    // TODO: Allow multiple locales
    public function alternateLocale(string $alternateLocale): static
    {
        return $this->setProperty('locale:alternate', $alternateLocale);
    }

    // TODO: Allow multiple audio
    public function audio(string $audio): static
    {
        return $this->setProperty(__FUNCTION__, $audio);
    }

    public function description(string $description): static
    {
        return $this->setProperty(__FUNCTION__, $description);
    }

    public function determiner(string $determiner): static
    {
        return $this->setProperty(__FUNCTION__, $determiner);
    }

    // TODO: Allow multiple images
    public function image(string $image): static
    {
        return $this->setProperty(__FUNCTION__, $image);
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

    // TODO: Allow multiple video
    public function video(string $video): static
    {
        return $this->setProperty(__FUNCTION__, $video);
    }
}
