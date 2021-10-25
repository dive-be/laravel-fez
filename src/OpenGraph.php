<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\OpenGraph\Objects\Article;
use Dive\Fez\OpenGraph\Objects\Book;
use Dive\Fez\OpenGraph\Objects\Profile;
use Dive\Fez\OpenGraph\Objects\Website;

final class OpenGraph
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
