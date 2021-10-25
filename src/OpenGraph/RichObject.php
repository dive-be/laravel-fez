<?php

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Container;
use Dive\Fez\OpenGraph\Properties\Audio;
use Dive\Fez\OpenGraph\Properties\Image;
use Dive\Fez\OpenGraph\Properties\Video;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class RichObject extends Container
{
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);

        $this->setProperty('type', Str::lower(class_basename(static::class)));
    }

    public function alternateLocale(array|string $alternateLocales): static
    {
        return $this->pushProperties(array_map(function ($locale) {
            return ['locale' . Property::DELIMITER . 'alternate', $locale];
        }, Arr::wrap($alternateLocales)));
    }

    public function audio(Audio|string $audioOrUrl): static
    {
        return $this->pushProperty([__FUNCTION__, $audioOrUrl]);
    }

    public function description(string $description): static
    {
        return $this->setProperty(__FUNCTION__, $description);
    }

    public function determiner(string $determiner): static
    {
        return $this->setProperty(__FUNCTION__, $determiner);
    }

    public function image(Image|string $imageOrUrl): static
    {
        return $this->pushProperty([__FUNCTION__, $imageOrUrl]);
    }

    public function locale(string $locale): static
    {
        return $this->setProperty(__FUNCTION__, $locale);
    }

    public function pushProperty($value): static
    {
        [$name, $value] = $value;

        return parent::pushProperty(is_string($value) ? Property::make($name, $value) : $value);
    }

    public function setProperty(string $name, $value): static
    {
        return parent::setProperty($name, is_string($value) ? Property::make($name, $value) : $value);
    }

    public function siteName(string $siteName): static
    {
        return $this->setProperty('site_name', $siteName);
    }

    public function title(string $title): static
    {
        return $this->setProperty(__FUNCTION__, $title);
    }

    public function url(string $url): static
    {
        return $this->setProperty(__FUNCTION__, $url);
    }

    public function video(Video|string $videoOrUrl): static
    {
        return $this->pushProperty([__FUNCTION__, $videoOrUrl]);
    }
}
