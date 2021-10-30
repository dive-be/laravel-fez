<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Component;
use Dive\Fez\Container;
use Dive\Fez\Contracts\Describable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\OpenGraph\Properties\Audio;
use Dive\Fez\OpenGraph\Properties\Image;
use Dive\Fez\OpenGraph\Properties\Video;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class RichObject extends Container implements Describable, Imageable, Titleable
{
    private const TYPE = 'type';

    public function __construct()
    {
        $this->setProperty(self::TYPE, $this->type());
    }

    public function alternateLocale(array|string $alternateLocales): static
    {
        return $this->pushMany(
            array_map(fn (string $locale) => $this->value('locale:alternate', $locale), Arr::wrap($alternateLocales))
        );
    }

    public function audio(Audio|string $audioOrUrl): static
    {
        return $this->pushProperty('audio', $audioOrUrl);
    }

    public function description(string $description): static
    {
        return $this->setProperty('description', $description);
    }

    public function determiner(string $determiner): static
    {
        return $this->setProperty('determiner', $determiner);
    }

    public function image(Image|string $imageOrUrl): static
    {
        return $this->pushProperty('image', $imageOrUrl);
    }

    public function locale(string $locale): static
    {
        return $this->setProperty('locale', $locale);
    }

    public function siteName(string $siteName): static
    {
        return $this->setProperty('site_name', $siteName);
    }

    public function title(string $title): static
    {
        return $this->setProperty('title', $title);
    }

    public function url(string $url): static
    {
        return $this->setProperty('url', $url);
    }

    public function video(Video|string $videoOrUrl): static
    {
        return $this->pushProperty('video', $videoOrUrl);
    }

    public function pushProperty(string $name, Component|string $content): static
    {
        return parent::push($this->value($name, $content));
    }

    public function setProperty(string $name, Component|string $content): static
    {
        return parent::set($name, $this->value($name, $content));
    }

    public function type(): string
    {
        return (string) Str::of(static::class)->classBasename()->lower();
    }

    private function value(string $name, Component|string $value): Component
    {
        return is_string($value) ? Property::make($name, $value) : $value;
    }

    public function toArray(): array
    {
        return [
            'properties' => parent::toArray(),
            'type' => $this->type(),
        ];
    }
}
