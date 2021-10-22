<?php

namespace Dive\Fez;

use Dive\Fez\Commands\InstallPackageCommand;
use Dive\Fez\Contracts\StaticPage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\View;

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
        $this->registerMacros();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/fez.php', 'fez');

        $this->registerManager();
        $this->registerStaticPage();
    }

    private function registerBladeDirectives()
    {
        $this->app->afterResolving('blade.compiler', static function (BladeCompiler $blade) {
            $blade->directive('fez', static fn (string $expression) => "<?php echo e(fez({$expression})) . PHP_EOL ?>");
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
            __DIR__ . '/../config/' . $config => $this->app->configPath($config),
        ], 'config');
    }

    private function registerManager()
    {
        $this->app->singleton('fez', static function (Application $app) {
            $finder = new Finder(fn () => $app->make('router')->getCurrentRoute());

            return new Fez($app->make(ComponentFactory::class), $finder);
        });

        $this->app->alias('fez', Fez::class);
    }

    private function registerMacros()
    {
        Route::macro('fez', function (string $binding) {
            /** @var Route $this */
            return $this->defaults(Finder::class, $binding);
        });

        View::macro('withFez', function ($property, $value = null) {
            app('fez')->set($property, $value);

            return $this;
        });
    }

    private function registerMigration()
    {
        $migration = 'create_fez_tables.php';
        $doesntExist = Collection::make(glob($this->app->databasePath('migrations/*.php')))
            ->every(fn ($filename) => ! str_ends_with($filename, $migration));

        if ($doesntExist) {
            $timestamp = date('Y_m_d_His', time());
            $stub = __DIR__ . "/../database/migrations/{$migration}.stub";

            $this->publishes([
                $stub => $this->app->databasePath("migrations/{$timestamp}_{$migration}"),
            ], 'migrations');
        }
    }

    private function registerStaticPage()
    {
        $this->app->alias(StaticPage::class, $staticPage = $this->app['config']['fez.models.static_page']);
        $this->app->bind(StaticPage::class, function (Application $app) use ($staticPage) {
            return call_user_func([$staticPage, 'resolve'], $app->make('fez'), $app->make('router')->getCurrentRoute());
        });
    }
}
