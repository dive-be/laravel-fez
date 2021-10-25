<?php declare(strict_types=1);

namespace Dive\Fez\TwitterCards;

use Dive\Fez\Property as Component;

final class Property extends Component
{
    public static function prefix(): string
    {
        return 'twitter';
    }
}
