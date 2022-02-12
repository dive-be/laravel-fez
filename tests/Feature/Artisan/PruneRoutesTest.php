<?php declare(strict_types=1);

namespace Tests\Feature\Artisan;

use Dive\Fez\Database\Factories\RouteFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;

it('bails out with error message if there are no routes to be pruned', function () {
    artisan('fez:prune')
        ->assertExitCode(Command::FAILURE)
        ->expectsOutput('🤚  There are no routes that should be pruned.')
        ->execute();
});

it('prunes defunct routes', function () {
    RouteFactory::times(3)->create();
    Route::get('a')->fez(1);

    artisan('fez:prune')
        ->assertExitCode(Command::SUCCESS)
        ->expectsOutput('🔥  Successfully pruned 2 route(s).')
        ->execute();

    assertDatabaseCount('routes', 1);
});
