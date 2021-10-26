<?php declare(strict_types=1);

namespace Dive\Fez\MetaElements;

use Dive\Fez\Component;
use Illuminate\Contracts\Routing\UrlGenerator;

class Canonical extends Component
{
    public function __construct(private UrlGenerator $url) {}

    public function generate(): string
    {
        return <<<HTML
<link rel="canonical" href="{$this->link()}" />
HTML;
    }

    public function toArray(): array
    {
        return ['canonical' => $this->link()];
    }

    private function link(): string
    {
        return $this->url->current();
    }
}
