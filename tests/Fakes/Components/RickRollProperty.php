<?php declare(strict_types=1);

namespace Tests\Fakes\Components;

use Dive\Fez\Component;

class RickRollProperty extends Component
{
    public function __construct(
        private string $value,
    ) {}

    public function value(): string
    {
        return $this->value;
    }

    public function render(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
        ];
    }
}
