<?php declare(strict_types=1);

namespace Tests\Unit\Commands;

use Dive\Fez\Database\Factories\RouteFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;

it('bails out with error message if there are no routes to be seeded', function () {
    artisan('fez:seed')
        ->assertExitCode(Command::FAILURE)
        ->expectsOutput('🤚  There are no routes that should be seeded.')
        ->execute();

    assertDatabaseCount('routes', 0);
});

it('seeds non-existing routes', function () {
    declareRoutes();

    assertDatabaseCount('routes', 0);

    artisan('fez:seed')
        ->assertExitCode(Command::SUCCESS)
        ->expectsOutput('🤙  Successfully seeded 2 route(s).')
        ->execute();

    assertDatabaseCount('routes', 2);
});

it('skips existing routes', function () {
    declareRoutes();

    RouteFactory::times(2)->sequence(
        ['id' => 1],
        ['id' => 3],
    )->create();

    assertDatabaseCount('routes', 2);

    artisan('fez:seed')
        ->assertExitCode(Command::SUCCESS)
        ->expectsOutput('🤙  Successfully seeded 2 route(s).') // in-memory db returns the affected count as-is
        ->execute();

    assertDatabaseCount('routes', 3);
});

function declareRoutes()
{
    Route::get('a')->fez(1);
    Route::get('b')->fez(2);
    Route::get('c')->fez('relevance');
}
