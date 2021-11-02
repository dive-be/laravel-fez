<?php declare(strict_types=1);

namespace Tests\Fakes\Components;

use Dive\Fez\Container;
use Dive\Fez\Contracts\Describable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Contracts\Titleable;

class RickRollContainer extends Container implements Describable, Imageable, Titleable
{
    public function description(string $description): self
    {
        return $this->set('description', RickRollProperty::make($description));
    }

    public function image(string $url): self
    {
        return $this->set('image', RickRollProperty::make($url));
    }

    public function title(string $title): self
    {
        return $this->set('title', RickRollProperty::make($title));
    }
}
