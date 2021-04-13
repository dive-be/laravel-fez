<?php

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Property as Component;

final class Property extends Component
{
    public const PREFIX = 'og';

    public function generate(): string
    {
        return '<meta property="'.self::delimit(self::PREFIX, $this->name).'" content="'.$this->content.'" />';
    }
}
