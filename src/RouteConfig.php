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
        $this->attributes = compact('parameterName');
        $this->strategy = 'binding';
    }

    public function name()
    {
        $this->attributes = [];
        $this->strategy = 'name';
    }

    public function none()
    {
        $this->attributes = [];
        $this->strategy = 'null';
    }

    public function relevance()
    {
        $this->attributes = [];
        $this->strategy = 'relevance';
    }

    public function smart()
    {
        $this->attributes = [];
        $this->strategy = 'smart';
    }

    public function toArray()
    {
        return [
            'attributes' => $this->attributes,
            'strategy' => $this->strategy,
        ];
    }
}
