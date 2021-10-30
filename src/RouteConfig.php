<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Support\Makeable;
use Illuminate\Contracts\Support\Arrayable;

class RouteConfig implements Arrayable
{
    use Makeable;

    private array $attributes = [];

    private ?string $strategy = 'null';

    public function binding(string $parameterName)
    {
        $this->strategy = 'binding';
        $this->attributes = compact('parameterName');
    }

    public function name()
    {
        $this->strategy = 'name';
    }

    public function none()
    {
        $this->strategy = 'null';
    }

    public function relevance()
    {
        $this->strategy = 'relevance';
    }

    public function toArray()
    {
        return [
            'attributes' => $this->attributes,
            'strategy' => $this->strategy,
        ];
    }
}
