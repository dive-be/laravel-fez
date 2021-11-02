<?php declare(strict_types=1);

namespace Dive\Fez\MetaElements;

use Dive\Fez\Component;

class Title extends Component
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
        return "<title>{$this->value}</title>";
    }

    public function toArray(): array
    {
        return [
            'attributes' => [
                'value' => $this->value,
            ],
            'type' => 'title',
        ];
    }
}
