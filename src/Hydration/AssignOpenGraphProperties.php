<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Factories\RichObjectFactory;
use Dive\Fez\Factories\StructuredPropertyFactory;
use Dive\Fez\FezManager;
use Dive\Fez\OpenGraph\RichObject;

class AssignOpenGraphProperties
{
    private array $pushables = ['audio', 'author', 'image', 'tag', 'video'];

    public function __construct()
    {
        $this->pushables = array_flip($this->pushables);
    }

    public function handle(FezManager $fez, Closure $next): FezManager
    {
        if (empty($source = $fez->metaData()->openGraph())) {
            return $next($fez);
        }

        $target = $this->selectTarget($fez->openGraph, $source['type']);
        $target = $this->assign($target, $source);

        $fez->openGraph = $target;

        return $next($fez);
    }

    private function assign($target, array $source, int $depth = 0)
    {
        foreach ($source['properties'] as $property) {
            if ($property['type'] === 'property') {
                ['attributes' => $attributes] = $property;

                $target->{$this->method($attributes['name'], $depth)}(...$attributes);
            } else {
                ['type' => $type] = $property;

                $target->{$this->method($type, $depth)}($type,
                    $this->assign(StructuredPropertyFactory::make()->create($type), $property, $depth + 1)
                );
            }
        }

        return $target;
    }

    private function method(string $name, int $depth): string
    {
        $method = $depth < 1 && array_key_exists($name, $this->pushables) ? 'push' : 'set';
        $method .= 'Property';

        return $method;
    }

    private function selectTarget(RichObject $current, string $source): RichObject
    {
        return $current->type() === $source
            ? $current
            : RichObjectFactory::make()->create($source);
    }
}
