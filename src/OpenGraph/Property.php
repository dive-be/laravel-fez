<?php

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Component;
use Dive\Fez\Support\Makeable;

final class Property extends Component
{
    use Makeable;

    public const PREFIX = 'og';

    public function __construct(private string $property, private string $content) {}

    public function generate(): string
    {
        return '<meta property="'.self::PREFIX.':'.$this->property.'" content="'.$this->content.'" />';
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'property' => $this->property,
        ];
    }
}
