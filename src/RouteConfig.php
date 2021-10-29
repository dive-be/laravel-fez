<?php

namespace Dive\Fez;

use Dive\Fez\Support\Makeable;
use Illuminate\Contracts\Support\Arrayable;

class RouteConfig implements Arrayable
{
    use Makeable;

    private array $attributes = [];

    private ?string $strategy = 'null';

    public function binding(string $parameterName): self
    {
        $this->strategy = 'binding';
        $this->attributes = compact('parameterName');

        return $this;
    }

    public function name(): self
    {
        $this->strategy = 'name';

        return $this;
    }

    public function none(): self
    {
        $this->strategy = 'null';

        return $this;
    }

    public function relevance(): self
    {
        $this->strategy = 'relevance';

        return $this;
    }

    public function toArray()
    {
        return [
            'attributes' => $this->attributes,
            'strategy' => $this->strategy,
        ];
    }
}
