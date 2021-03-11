<?php

namespace Tests;

use function Pest\Laravel\artisan;

afterEach(function () {
    file_exists(config_path('fez.php')) && unlink(config_path('fez.php'));
    array_map('unlink', glob(database_path('migrations/*_create_fez_tables.php')));
});

it('copies the config', function () {
    artisan('fez:install')->execute();

    expect(file_exists(config_path('fez.php')))->toBeTrue();
});

it('copies the migration', function () {
    artisan('fez:install')->execute();

    expect(glob(database_path('migrations/*_create_fez_tables.php')))->toHaveCount(1);
});
