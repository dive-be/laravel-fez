<?php declare(strict_types=1);

namespace Dive\Fez\TwitterCards;

use Dive\Fez\Component;

final class Property extends Component
{
    public function __construct(private string $name, private string $content) {}

    public function content(): string
    {
        return $this->content;
    }

    public function generate(): string
    {
        return "<meta name='twitter:{$this->name}' content='{$this->content}' />";
    }

    public function name(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'name' => $this->name,
        ];
    }
}
