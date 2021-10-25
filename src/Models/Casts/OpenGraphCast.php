<?php

namespace Dive\Fez\Models\Casts;

use Closure;
use Dive\Fez\Exceptions\SorryUnexpectedComponent;
use Dive\Fez\OpenGraph\Objects\Article;
use Dive\Fez\OpenGraph\Objects\Book;
use Dive\Fez\OpenGraph\Objects\Profile;
use Dive\Fez\OpenGraph\Objects\Website;
use Dive\Fez\OpenGraph\Properties\Audio;
use Dive\Fez\OpenGraph\Properties\Image;
use Dive\Fez\OpenGraph\Properties\Video;
use Dive\Fez\OpenGraph\Property;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class OpenGraphCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $tree = json_decode($value, true);

        if (is_null($tree)) {
            return $tree;
        }

        ['content' => $type] = Arr::pull($tree, 'type');

        return call_user_func(
            [$this->getRichObject($type), 'make'],
            array_map($this->propertyCaster(), $tree),
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value->toJson();
    }

    private function getRichObject(string $name): string
    {
        return match ($name) {
            'article' => Article::class,
            'book' => Book::class,
            'profile' => Profile::class,
            'website' => Website::class,
            default => throw SorryUnexpectedComponent::make($name),
        };
    }

    private function getStructuredProperty(string $name): string
    {
        return match (Str::before($name, Property::DELIMITER)) {
            'audio' => Audio::class,
            'image' => Image::class,
            'video' => Video::class,
            default => throw SorryUnexpectedComponent::make($name),
        };
    }

    private function isSimpleProperty(array $prop): bool
    {
        return Arr::hasAny($prop, ['content', 'name']);
    }

    private function propertyCaster(): Closure
    {
        return function (array $prop) {
            if ($this->isSimpleProperty($prop)) {
                return Property::make(Arr::get($prop, 'name'), Arr::get($prop, 'content'));
            }

            return call_user_func(
                [$this->getStructuredProperty(array_key_first($prop)), 'make'],
                array_map($this->propertyCaster(), $prop),
            );
        };
    }
}
