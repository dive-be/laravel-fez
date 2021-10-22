<?php

namespace Dive\Fez;

use Dive\Fez\Commands\InstallPackageCommand;
use Dive\Fez\Contracts\StaticPage;
use Dive\Fez\Exceptions\SorryNoFeaturesActive;
use Dive\Fez\Macros\RouteMacro;
use Dive\Fez\Macros\ViewMacro;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class FezServiceProvider extends ServiceProvider
{
    private array $macros = [
        RouteMacro::class,
        ViewMacro::class,
    ];

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
            if (empty($features = Feature::enabled())) {
                throw SorryNoFeaturesActive::make();
            }

            $components = array_combine($features, array_map([$app->make(ComponentFactory::class), 'make'], $features));
            $finder = new Finder(fn () => $app->make('router')->getCurrentRoute());

            return new Fez($finder, $components);
        });

        $this->app->alias('fez', Fez::class);
    }

    private function registerMacros()
    {
        foreach ($this->macros as $macro) {
            call_user_func([$macro, 'register']);
        }
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
