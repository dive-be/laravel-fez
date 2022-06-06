<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\Exceptions\SorryUnknownOpenGraphObjectType;
use Dive\Fez\OpenGraph\Objects\Article;
use Dive\Fez\OpenGraph\Objects\Book;
use Dive\Fez\OpenGraph\Objects\Profile;
use Dive\Fez\OpenGraph\Objects\Website;
use Dive\Fez\OpenGraph\RichObject;
use Dive\Utils\Makeable;

class RichObjectFactory
{
    use Makeable;

    public function create(string $type): RichObject
    {
        return match ($type) {
            'article' => Article::make(),
            'book' => Book::make(),
            'profile' => Profile::make(),
            'website' => Website::make(),
            default => throw SorryUnknownOpenGraphObjectType::make($type),
        };
    }
}
