<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph;

use Dive\Fez\Component;

class Property extends Component
{
    public function __construct(
        private string $name,
        private string $content,
    ) {}

    public function content(): string
    {
        return $this->content;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function render(): string
    {
        return <<<HTML
<meta property="og:{$this->name}" content="{$this->content}" />
HTML;
    }

    public function toArray(): array
    {
        return [
            'attributes' => [
                'content' => $this->content,
                'name' => $this->name,
            ],
            'type' => 'property',
        ];
    }
}
