<?php declare(strict_types=1);

namespace Tests\Integration;

use Dive\Fez\Database\Factories\MetaFactory;
use Dive\Fez\MetaData;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Tests\Fakes\Factories\PostWithDefaultsFactory;
use Tests\Fakes\Models\Post;

it('defines a meta relation', function () {
    expect((new Post())->meta())
        ->toBeInstanceOf(MorphOne::class)
        ->getForeignKeyName()->toBe('metable_id')
        ->getMorphType()->toBe('metable_type');
});

it('can gather meta data using the defaults *only*', function () {
    $post = PostWithDefaultsFactory::new()->make();

    expect($post->gatherMetaData())
        ->toBeInstanceOf(MetaData::class)
        ->description->toBe($post->short_description)
        ->image->toBe($post->hero)
        ->title->toBe($post->title)
        ->elements->toBeNull()
        ->open_graph->toBeNull()
        ->twitter->toBeNull();
});

it('can gather meta data using defaults *and* meta relation', function () {
    $post = PostWithDefaultsFactory::new()
        ->make()
        ->setRelation('meta', MetaFactory::new()->withDescription()->withImage()->make());

    expect($post->gatherMetaData())
        ->toBeInstanceOf(MetaData::class)
        ->description->not->toBe($post->short_description) // relational data takes precedence
        ->image->not->toBe($post->hero) // relational data takes precedence
        ->title->toBe($post->title)
        ->elements->toBeNull()
        ->open_graph->toBeNull()
        ->twitter->toBeNull();
});
