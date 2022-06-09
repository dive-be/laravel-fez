<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Utils\Makeable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Config;

class RouteConfig implements Arrayable
{
    use Makeable;

    private array $attributes = [];

    private ?string $strategy = 'null';

    public static function default(): self
    {
        $method = Config::get('fez.finder.strategy');

        return tap(static::make())->{$method}();
    }

    public function binding(string $parameterName)
    {
        $this->attributes = compact('parameterName');
        $this->strategy = 'binding';
    }

    public function none()
    {
        $this->null();
    }

    public function null()
    {
        $this->attributes = [];
        $this->strategy = 'null';
    }

    public function relevance()
    {
        $this->attributes = [];
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
