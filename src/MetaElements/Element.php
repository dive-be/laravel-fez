<?php declare(strict_types=1);

namespace Dive\Fez\MetaElements;

use Dive\Fez\Component;

class Element extends Component
{
    public function __construct(
        private string $name,
        private string $content,
    ) {}

    public function generate(): string
    {
        return <<<HTML
<meta name="{$this->name}" content="{$this->content}" />
HTML;
    }

    public function toArray(): array
    {
        return [
            'attributes' => [
                'content' => $this->content,
                'name' => $this->name,
            ],
            'type' => 'element',
        ];
    }
}
