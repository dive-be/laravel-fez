<?php declare(strict_types=1);

namespace Tests;

use Dive\Fez\FezServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
        $this->setUpViews($this->app);
    }

    protected function getPackageProviders($app): array
    {
        return [FezServiceProvider::class];
    }

    protected function setUpDatabase(Application $app)
    {
        $schema = $app->make('db.connection')->getSchemaBuilder();
        $schema->dropAllTables();

        $fez = require __DIR__ . '/../database/migrations/create_fez_tables.php.stub';

        $schema->create('posts', static function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->string('hero');
            $table->string('title');
            $table->string('short_description');
            $table->tinyText('body');
        });

        $fez->up();
    }

    protected function setUpViews(Application $app)
    {
        $app->make('view')->addNamespace('test', __DIR__ . '/resources/views');
    }
}
