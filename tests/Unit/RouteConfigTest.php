<?php declare(strict_types=1);

namespace Tests\Unit;

use Dive\Fez\Models\Route;
use Dive\Fez\RouteConfig;

it('can configure various strategies', function () {
    $config = RouteConfig::make();

    expect(
        tap($config)->relevance()->toArray()
    )->toMatchArray([
        'attributes' => [],
        'strategy' => 'relevance',
    ]);

    expect(
        tap($config)->smart()->toArray()
    )->toMatchArray([
        'attributes' => [
            'model' => Route::class,
        ],
        'strategy' => 'smart',
    ]);

    expect(
        tap($config)->binding('rick_astley')->toArray()
    )->toMatchArray([
        'attributes' => [
            'parameterName' => 'rick_astley',
        ],
        'strategy' => 'binding',
    ]);

    expect(
        tap($config)->none()->toArray()
    )->toMatchArray([
        'attributes' => [],
        'strategy' => 'null',
    ]);

    expect(
        tap($config)->name()->toArray()
    )->toMatchArray([
        'attributes' => [
            'model' => Route::class,
        ],
        'strategy' => 'name',
    ]);
});
