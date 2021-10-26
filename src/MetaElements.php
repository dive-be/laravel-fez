<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Formatter;
use Dive\Fez\MetaElements\Canonical;
use Dive\Fez\MetaElements\Element;
use Dive\Fez\MetaElements\Title;
use Illuminate\Contracts\Routing\UrlGenerator;

final class MetaElements extends ComponentBag
{
    public function __construct(
        private UrlGenerator $url,
        private Formatter $formatter,
    ) {}

    public function canonical(): self
    {
        return $this->set(__FUNCTION__, Canonical::make($this->url->current()));
    }

    public function description(string $description): self
    {
        return $this->set(__FUNCTION__, Element::make(__FUNCTION__, $description));
    }

    public function keywords(string $keywords): self
    {
        return $this->set(__FUNCTION__, Element::make(__FUNCTION__, $keywords));
    }

    public function robots(string $robots): self
    {
        return $this->set(__FUNCTION__, Element::make(__FUNCTION__, $robots));
    }

    public function title(string $title): self
    {
        return $this->set(__FUNCTION__, Title::make($this->formatter->format($title)));
    }
}
