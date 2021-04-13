<?php

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Property as Component;

final class Property extends Component
{
    public const DELIMITER = ':';
    public const PREFIX = 'og';

    public function generate(): string
    {
        return '<meta property="'.self::PREFIX.self::DELIMITER.$this->name.'" content="'.$this->content.'" />';
    }
}
