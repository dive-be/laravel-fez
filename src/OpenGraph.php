<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\OpenGraph\Objects\Article;
use Dive\Fez\OpenGraph\Objects\Book;
use Dive\Fez\OpenGraph\Objects\Profile;
use Dive\Fez\OpenGraph\Objects\Website;
use Dive\Fez\OpenGraph\Properties\Audio;
use Dive\Fez\OpenGraph\Properties\Image;
use Dive\Fez\OpenGraph\Properties\Video;

class OpenGraph
{
    public static function article(): Article
    {
        return Article::make();
    }

    public static function audio(): Audio
    {
        return Audio::make();
    }

    public static function book(): Book
    {
        return Book::make();
    }

    public static function image(): Image
    {
        return Image::make();
    }

    public static function profile(): Profile
    {
        return Profile::make();
    }

    public static function video(): Video
    {
        return Video::make();
    }

    public static function website(): Website
    {
        return Website::make();
    }
}
