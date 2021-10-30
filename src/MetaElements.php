<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Describable;
use Dive\Fez\Contracts\Titleable;
use Dive\Fez\MetaElements\Canonical;
use Dive\Fez\MetaElements\Element;
use Dive\Fez\MetaElements\Title;

class MetaElements extends Container implements Describable, Titleable
{
    public function canonical(string $url): self
    {
        return $this->set('canonical', Canonical::make($url));
    }

    public function description(string $description): self
    {
        return $this->set('description', Element::make('description', $description));
    }

    public function keywords(string $keywords): self
    {
        return $this->set('keywords', Element::make('keywords', $keywords));
    }

    public function robots(string $robots): self
    {
        return $this->set('robots', Element::make('robots', $robots));
    }

    public function title(string $title): self
    {
        return $this->set('title', Title::make($title));
    }
}
