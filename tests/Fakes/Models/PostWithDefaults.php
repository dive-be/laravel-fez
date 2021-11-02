<?php declare(strict_types=1);

namespace Tests\Fakes\Models;

class PostWithDefaults extends Post
{
    protected array $metaDefaults = [
        'description' => 'short_description',
        'image' => 'hero',
        'title' => 'title',
    ];
}
