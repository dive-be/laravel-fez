<?php

namespace Dive\Fez\TwitterCards;

use Dive\Fez\Property as Component;
use Dive\Fez\TwitterCards;

final class Property extends Component
{
    public const PREFIX = 'twitter';

    public function generate(): string
    {
        return '<meta name="'.self::PREFIX.TwitterCards::DELIMITER.$this->name.'" content="'.$this->content.'" />';
    }
}
