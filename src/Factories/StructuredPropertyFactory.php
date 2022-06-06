<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Exceptions\UnknownOpenGraphObjectException;
use Dive\Fez\OpenGraph\Properties\Audio;
use Dive\Fez\OpenGraph\Properties\Image;
use Dive\Fez\OpenGraph\Properties\Video;
use Dive\Fez\OpenGraph\StructuredProperty;
use Dive\Utils\Makeable;

class StructuredPropertyFactory
{
    use Makeable;

    public function create(string $type): StructuredProperty
    {
        return match ($type) {
            'audio' => Audio::make(),
            'image' => Image::make(),
            'video' => Video::make(),
            default => throw UnknownOpenGraphObjectException::make($type),
        };
    }
}
