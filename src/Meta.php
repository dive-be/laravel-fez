<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Hydratable;
use Dive\Fez\Models\MetaData;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class Meta extends Container implements Hydratable
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

    public function hydrate(MetaData $data): void
    {
        $this->properties = array_merge(
            $this->properties,
            array_filter($data->only('description', 'keywords', 'robots', 'title')),
        );
    }
}
