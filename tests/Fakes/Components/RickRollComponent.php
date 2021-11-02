<?php declare(strict_types=1);

namespace Tests\Fakes\Components;

use Dive\Fez\Component;

class RickRollComponent extends Component
{
    public function render(): string
    {
        return 'Never Gonna Give You Up';
    }

    public function toArray(): array
    {
        return [
            'type' => 'rick_roll',
            'value' => 'Never Gonna Give You Up',
        ];
    }
}
