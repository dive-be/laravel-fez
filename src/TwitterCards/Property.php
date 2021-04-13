<?php

namespace Dive\Fez\TwitterCards;

use Dive\Fez\Property as Component;

final class Property extends Component
{
    public const PREFIX = 'twitter';

    public function generate(): string
    {
        return '<meta name="'.self::delimit(self::PREFIX, $this->name).'" content="'.$this->content.'" />';
    }
}
