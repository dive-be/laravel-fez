<?php

namespace Dive\Fez;

abstract class Property extends Component
{
    public const DELIMITER = ':';

    public function __construct(protected string $name, protected string $content) {}

    public static function delimit(...$values): string
    {
        return implode(self::DELIMITER, $values);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getName(): string
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
