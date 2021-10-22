<?php

namespace Tests;

use CreateFezTables;
use Dive\Fez\FezServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [FezServiceProvider::class];
    }

    protected function setUpDatabase($app)
    {
        $app->make('db')->connection()->getSchemaBuilder()->dropAllTables();

        require_once __DIR__ . '/../database/migrations/create_fez_tables.php.stub';

        (new CreateFezTables())->up();
    }
}
