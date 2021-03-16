<?php

namespace Dive\Fez;

use Dive\Fez\Commands\InstallPackageCommand;
use Dive\Fez\Contracts\StaticPage as StaticPageContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class FezServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->registerConfig();
            $this->registerMigration();
        }

        $this->registerBladeDirectives();
        $this->registerRouteMacro();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/fez.php', 'fez');

        $this->app->alias(Fez::class, 'fez');

        $this->app->singleton(Fez::class, static function (Application $app) {
            return new Fez(array_unique($app['config']['fez.features']), $app->make(ComponentFactory::class));
        });

        $this->app->bind(StaticPageContract::class, fn (Application $app) => call_user_func(
            [$app->make('config')->get('fez.models.static_page'), 'resolve'],
            $app->make('fez'),
            $app->make('router')->getCurrentRoute()
        ));
    }

    private function registerBladeDirectives()
    {
        $this->app->make('blade.compiler')->directive('fez', static function ($expression) {
            return "<?php echo e(fez({$expression})).PHP_EOL ?>";
        });
    }

    private function registerCommands()
    {
        $this->commands([
            InstallPackageCommand::class,
        ]);
    }

    private function registerConfig()
    {
        $config = 'fez.php';

        $this->publishes([
            __DIR__.'/../config/'.$config => $this->app->configPath($config),
        ], 'config');
    }

    private function registerMigration()
    {
        $migration = 'create_fez_tables.php';
        $doesntExist = Collection::make(glob($this->app->databasePath('migrations/*.php')))
            ->every(fn ($filename) => ! str_ends_with($filename, $migration));

        if ($doesntExist) {
            $timestamp = date('Y_m_d_His', time());
            $stub = __DIR__."/../database/migrations/{$migration}.stub";

            $this->publishes([
                $stub => $this->app->databasePath("migrations/{$timestamp}_{$migration}"),
            ], 'migrations');
        }
    }

    private function registerRouteMacro()
    {
        Route::macro('fez', function (string $binding) {
            app('fez')->acceptBinding($binding);

            return $this;
        });
    }
}
