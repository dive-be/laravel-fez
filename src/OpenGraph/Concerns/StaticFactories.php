<?php declare(strict_types=1);

namespace Dive\Fez\OpenGraph\Concerns;

use Dive\Fez\OpenGraph\Objects\Article;
use Dive\Fez\OpenGraph\Objects\Book;
use Dive\Fez\OpenGraph\Objects\Profile;
use Dive\Fez\OpenGraph\Objects\Website;

trait StaticFactories
{
    public static function article(): Article
    {
        return Article::make();
    }

    public static function book(): Book
    {
        return Book::make();
    }

    public static function profile(): Profile
    {
        return Profile::make();
    }

    public static function website(): Website
    {
        return Website::make();
    }
}
