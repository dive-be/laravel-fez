<?php declare(strict_types=1);

namespace Dive\Fez\MetaElements;

use Dive\Fez\Component;

class Element extends Component
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
        $content = e($this->content);
        $name = e($this->name);

        return <<<HTML
<meta name="{$name}" content="{$content}" />
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
