<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Commands\AutoIncrementCommand;
use Dive\Fez\Commands\InstallPackageCommand;
use Dive\Fez\Commands\PruneRoutesCommand;
use Dive\Fez\Commands\SeedRoutesCommand;
use Dive\Fez\Commands\SyncRoutesCommand;
use Dive\Fez\Factories\FeatureFactory;
use Dive\Fez\Macros\PropertySetter;
use Dive\Fez\Macros\RouteConfigurator;
use Dive\Fez\Middleware\HydrateFromParameters;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class FezServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__ . '/../config/fez.php', 'fez');

        $this->registerMacros();
        $this->registerManager();
        $this->registerMorphMap();

        $this->callAfterResolving('blade.compiler', $this->registerDirectives(...));
        $this->callAfterResolving('router', $this->registerMiddleware(...));
    }

    private function registerDirectives(BladeCompiler $blade)
    {
        $blade->directive('fez',
            static fn ($args) => '<?php echo e(fez()' . (empty($args) ? '' : "->only({$args})") . ') . PHP_EOL ?>'
        );
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
        PropertySetter::register();
        RouteConfigurator::register();
    }

    private function registerManager()
    {
        $this->app->alias('fez', FezManager::class);
        $this->app->singleton('fez', static function (Application $app) {
            $factory = FeatureFactory::make($app['config']['fez'])
                ->setLocaleResolver(static fn () => $app->getLocale())
                ->setRequestResolver(static fn () => $app['request'])
                ->setUrlResolver(static fn () => $app['url']);

            return FezManager::make(
                array_combine($features = Feature::enabled(), array_map($factory->create(...), $features))
            );
        });
    }

    private function registerMiddleware(Router $router)
    {
        $router->aliasMiddleware('fez', HydrateFromParameters::class);
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

    private function registerMorphMap()
    {
        Relation::morphMap($this->app['config']['fez.models']);
    }
}
