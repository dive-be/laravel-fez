<?php declare(strict_types=1);

namespace Dive\Fez\MetaElements;

use Dive\Fez\Component;

class ArrayElement extends Component
{
    public function __construct(private string $name, private array $content) {}

    public function generate(): string
    {
        $delimited = implode(', ', $this->content);

        return "<meta name='{$this->name}' content='{$delimited}' />";
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'name' => $this->name,
        ];
    }
}
