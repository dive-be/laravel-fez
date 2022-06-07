<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Commands\AutoIncrementCommand;
use Dive\Fez\Commands\InstallPackageCommand;
use Dive\Fez\Commands\PruneRoutesCommand;
use Dive\Fez\Commands\SeedRoutesCommand;
use Dive\Fez\Commands\SyncRoutesCommand;
use Dive\Fez\Factories\FeatureFactory;
use Dive\Fez\Http\Middleware\LoadFromRoute;
use Dive\Fez\Macros\PropertySetter;
use Dive\Fez\Macros\RouteConfigurator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\View;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->registerConfig();
            $this->registerMigration();
        }
    }

    public function register()
    {
        $this->callAfterResolving(BladeCompiler::class, $this->registerDirectives(...));
        $this->callAfterResolving(Router::class, $this->registerMiddleware(...));

        $this->registerMacros();
        $this->registerManager();

        $this->mergeConfigFrom(__DIR__ . '/../config/fez.php', 'fez');
    }

    private function registerDirectives(BladeCompiler $blade)
    {
        $blade->directive('fez', Directive::compile(...));
    }

    private function registerCommands()
    {
        $this->commands([
            AutoIncrementCommand::class,
            InstallPackageCommand::class,
            PruneRoutesCommand::class,
            SeedRoutesCommand::class,
            SyncRoutesCommand::class,
        ]);
    }

    private function registerConfig()
    {
        $config = 'fez.php';

        $this->publishes([
            __DIR__ . '/../config/' . $config => $this->app->configPath($config),
        ], 'config');
    }

    private function registerMacros()
    {
        Route::mixin(new RouteConfigurator());
        View::mixin(new PropertySetter());
    }

    private function registerManager()
    {
        $this->app->alias('fez', Manager::class);
        $this->app->singleton('fez', static function (Application $app) {
            $factory = FeatureFactory::make($app['config']['fez'])
                ->setLocaleResolver(static fn () => $app->getLocale())
                ->setRequestResolver(static fn () => $app['request'])
                ->setUrlResolver(static fn () => $app['url']);

            return Manager::make(
                array_combine($features = Feature::enabled(), array_map($factory->create(...), $features))
            );
        });
    }

    private function registerMiddleware(Router $router)
    {
        $router->aliasMiddleware('fez', LoadFromRoute::class);
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
}
