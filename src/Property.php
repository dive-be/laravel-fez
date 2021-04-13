<?php

namespace Dive\Fez;

abstract class Property extends Component
{
    public function __construct(protected string $name, protected string $content) {}

    public function getContent(): string
    {
        return $this->content;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'name' => $this->name,
        ];
    }
}
