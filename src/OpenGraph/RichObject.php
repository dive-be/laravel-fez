<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Component;
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

        $this->setProperty('type', (string) Str::of(static::class)->classBasename()->lower());
    }

    public function alternateLocale(array|string $alternateLocales): static
    {
        return $this->pushMany(
            array_map(fn (string $locale) => $this->value('locale:alternate', $locale), Arr::wrap($alternateLocales))
        );
    }

    public function audio(Audio|string $audioOrUrl): static
    {
        return $this->pushProperty(__FUNCTION__, $audioOrUrl);
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
        return $this->pushProperty(__FUNCTION__, $imageOrUrl);
    }

    public function locale(string $locale): static
    {
        return $this->setProperty(__FUNCTION__, $locale);
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
        return $this->pushProperty(__FUNCTION__, $videoOrUrl);
    }

    protected function pushProperty(string $name, Component|string $value): static
    {
        return parent::push($this->value($name, $value));
    }

    protected function setProperty(string $name, Component|string $value): static
    {
        return parent::set($name, $this->value($name, $value));
    }

    private function value(string $name, Component|string $value): Component
    {
        return is_string($value) ? Property::make($name, $value) : $value;
    }
}
