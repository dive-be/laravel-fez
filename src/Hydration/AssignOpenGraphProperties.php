<?php declare(strict_types=1);

namespace Dive\Fez\Hydration;

use Closure;
use Dive\Fez\Exceptions\SorryUnknownOpenGraphObjectType;
use Dive\Fez\FezManager;
use Dive\Fez\OpenGraph;
use Dive\Fez\OpenGraph\RichObject;
use Dive\Fez\OpenGraph\StructuredProperty;

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

        $target = $this->selectTarget($fez->openGraph, $source);
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
                    $this->assign($this->createStructuredProperty($type), $property, $depth + 1)
                );
            }
        }

        return $target;
    }

    private function createRichObject(string $type): RichObject
    {
        return match ($type) {
            'article' => OpenGraph::article(),
            'book' => OpenGraph::book(),
            'profile' => OpenGraph::profile(),
            'website' => OpenGraph::website(),
            default => throw SorryUnknownOpenGraphObjectType::make($type),
        };
    }

    private function createStructuredProperty(string $type): StructuredProperty
    {
        return match ($type) {
            'audio' => OpenGraph::audio(),
            'image' => OpenGraph::image(),
            'video' => OpenGraph::video(),
            default => throw SorryUnknownOpenGraphObjectType::make($type),
        };
    }

    private function method(string $name, int $depth): string
    {
        $method = $depth < 1 && array_key_exists($name, $this->pushables) ? 'push' : 'set';
        $method .= 'Property';

        return $method;
    }

    private function selectTarget(RichObject $current, array $source): RichObject
    {
        $type = $source['type'];

        if ($current->type() === $type) {
            return $current;
        }

        return $this->createRichObject($type);
    }
}
