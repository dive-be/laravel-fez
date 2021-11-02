<?php declare(strict_types=1);

namespace Tests\Unit\Models;

use Dive\Fez\Models\Meta;
use Illuminate\Database\Eloquent\Relations\MorphTo;

beforeEach(function () {
    $this->model = new Meta();
});

it('defines casts', function () {
    expect(
        $this->model->getCasts()
    )->toMatchArray([
        'elements' => 'array',
        'open_graph' => 'array',
        'twitter' => 'array',
    ]);
});

it('defines a singular table name', function () {
    expect(
        $this->model->getTable()
    )->toBe('meta');
});

it('defines visibility', function () {
    expect(
        $this->model->getVisible()
    )->toMatchArray([
        'description',
        'elements',
        'image',
        'open_graph',
        'title',
        'twitter',
    ]);
});

it('defines a metable relation', function () {
    expect($this->model->metable())->toBeInstanceOf(MorphTo::class);
    expect($this->model->metable()->getRelationName())->toBe('metable');
});
