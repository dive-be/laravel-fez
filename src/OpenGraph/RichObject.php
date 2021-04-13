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
    public function __construct(array|string $properties = [])
    {
        if (is_string($properties)) {
            $properties = ['title' => Property::make('title', $properties)];
        }

        parent::__construct($this->initialize($properties));
    }

    public function alternateLocale(array|string $alternateLocale): static
    {
        return $this->pushProperties(array_map(function ($locale) {
            return Property::make('locale:alternate', $locale);
        }, Arr::wrap($alternateLocale)));
    }

    public function audio(Audio|string $audio): static
    {
        return $this->pushProperty(is_string($audio) ? Property::make(__FUNCTION__, $audio) : $audio);
    }

    public function description(string $description): static
    {
        return $this->setProperty(__FUNCTION__, Property::make(__FUNCTION__, $description));
    }

    public function determiner(string $determiner): static
    {
        return $this->setProperty(__FUNCTION__, Property::make(__FUNCTION__, $determiner));
    }

    public function image(Image|string $image): static
    {
        return $this->pushProperty(is_string($image) ? Property::make(__FUNCTION__, $image) : $image);
    }

    public function locale(string $locale): static
    {
        return $this->setProperty(__FUNCTION__, Property::make(__FUNCTION__, $locale));
    }

    public function siteName(string $siteName): static
    {
        return $this->setProperty(__FUNCTION__, Property::make('site_name', $siteName));
    }

    public function title(string $title): static
    {
        return $this->setProperty(__FUNCTION__, Property::make(__FUNCTION__, $title));
    }

    public function url(string $url): static
    {
        return $this->setProperty(__FUNCTION__, Property::make(__FUNCTION__, $url));
    }

    public function video(Video|string $video): static
    {
        return $this->pushProperty(is_string($video) ? Property::make(__FUNCTION__, $video) : $video);
    }

    private function initialize(array $properties): array
    {
        foreach ($properties as $name => $property) {
            if (! $property instanceof Property) {
                $properties[$name] = Property::make($name, $property);
            }
        }

        return $properties + ['type' => Property::make('type', Str::lower(class_basename(static::class)))];
    }
}
