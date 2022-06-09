<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Commands\InstallPackageCommand;
use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Exceptions\NoFeaturesActiveException;
use Dive\Fez\Factories\FeatureFactory;
use Dive\Fez\Factories\FormatterFactory;
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
        $this->registerMacros();

        $this->app->afterResolving(BladeCompiler::class, $this->registerDirectives(...));
        $this->app->afterResolving(Router::class, $this->registerMiddleware(...));
        $this->app->singleton('fez', $this->createManager(...));
        $this->app->alias('fez', Manager::class);
        $this->app->bind(Formatter::class, $this->createFormatter(...));

        $this->mergeConfigFrom(__DIR__ . '/../config/fez.php', 'fez');
    }

    private function createFormatter(Application $app): Formatter
    {
        return $app->make(FormatterFactory::class)->create($app['config']['fez.title']);
    }

    private function createManager(Application $app): Manager
    {
        $factory = FeatureFactory::make($app['config']['fez'])
            ->setLocaleResolver(static fn () => $app->getLocale())
            ->setRequestResolver(static fn () => $app['request'])
            ->setUrlResolver(static fn () => $app['url']);

        $features = Feature::enabled();

        if (! count($features)) {
            throw NoFeaturesActiveException::make();
        }

        $features = array_combine($features, array_map($factory->create(...), $features));

        return Manager::make($features);
    }

    private function registerDirectives(BladeCompiler $blade)
    {
        $blade->directive('fez', Directive::compile(...));
    }

    private function registerCommands()
    {
        $this->commands([
            InstallPackageCommand::class,
        ]);
    }

    private function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/fez.php' => $this->app->configPath('fez.php'),
        ], 'config');
    }

    private function registerMacros()
    {
        Route::mixin(new RouteConfigurator());
        View::mixin(new PropertySetter());
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
