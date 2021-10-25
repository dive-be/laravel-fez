<?php declare(strict_types=1);

namespace Dive\Fez;

abstract class Property extends Component
{
    public const DELIMITER = ':';

    public function __construct(protected string $name, protected string $content) {}

    abstract public static function prefix(): string;

    public function content(): string
    {
        return $this->content;
    }

    public function generate(): string
    {
        $qualifiedName = implode(self::DELIMITER, [static::prefix(), $this->name]);

        return "<meta name='{$qualifiedName}' content='{$this->content}' />";
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
