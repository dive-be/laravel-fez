<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Utils\Makeable;

class MetaData
{
    use Makeable;

    public function __construct(
        public readonly ?string $description = null,
        public readonly ?array $elements = null,
        public readonly ?string $image = null,
        public readonly ?array $open_graph = null,
        public readonly ?string $title = null,
        public readonly ?array $twitter = null,
    ) {}
}
