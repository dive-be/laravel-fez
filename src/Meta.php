<?php

namespace Dive\Fez;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class Meta extends Container
{
    private bool $canonical;

    public function __construct(
        private TitleFormatter $formatter,
        private UrlGenerator $url,
        array $defaults
    ) {
        $this->canonical = Arr::pull($defaults, 'canonical', true);

        parent::__construct(Arr::except($defaults, 'image'));
    }

    public function generate(): string
    {
        $properties = $this->collect();
        $title = $this->formatter->format($properties->pull('title'));

        return $properties->map(static function (array|string $content) {
            return is_array($content) ? implode(', ', $content) : $content;
        })->map(static function (string $content, string $name) {
            return "<meta name='{$name}' content='{$content}' />";
        })->prepend("<title>{$title}</title>")->when($this->canonical, function (Collection $props) {
            return $props->push("<link rel='canonical' href='{$this->url->current()}' />");
        })->join(PHP_EOL);
    }
}
