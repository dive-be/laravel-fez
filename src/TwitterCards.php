<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Contracts\Imageable;
use Dive\Fez\TwitterCards\Concerns\StaticFactories;

final class TwitterCards extends Container implements Imageable
{
    use StaticFactories;

    public function __construct(private TitleFormatter $formatter, array $defaults)
    {
        parent::__construct($defaults);
    }

    public function generate(): string
    {
        return $this->collect()->map(function (string $content, string $prop) {
            return $prop === 'title' ? $this->formatter->format($content) : $content;
        })->map(static function (string $content, string $prop) {
            return "<meta property='twitter:{$prop}' content='{$content}' />";
        })->join(PHP_EOL);
    }
}
