<?php declare(strict_types=1);

namespace Dive\Fez\MetaElements;

use Dive\Fez\Component;

class Canonical extends Component
{
    public function __construct(
        private string $url,
    ) {}

    public function url(): string
    {
        return $this->url;
    }

    public function render(): string
    {
        return <<<HTML
<link rel="canonical" href="{$this->url}" />
HTML;
    }

    public function toArray(): array
    {
        return [
            'attributes' => [
                'url' => $this->url,
            ],
            'type' => 'canonical',
        ];
    }
}
