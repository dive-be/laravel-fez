<?php declare(strict_types=1);

namespace Dive\Fez;

use Dive\Fez\Commands\InstallPackageCommand;
use Dive\Fez\Factories\FeatureFactory;
use Dive\Fez\Macros\MetableFinder;
use Dive\Fez\Macros\PropertySetter;
use Dive\Fez\Macros\RouteConfigurator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Relations\Relation;
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

        $this->registerBladeDirectives();
        $this->registerMacros();
        $this->registerManager();
        $this->registerMorphMap();
    }

    private function registerBladeDirectives()
    {
        $this->callAfterResolving('blade.compiler', static function (BladeCompiler $blade) {
            $blade->directive('fez',
                static fn ($args) => '<?php echo e(fez()' . (empty($args) ? '' : "->only({$args})") . ') . PHP_EOL ?>'
            );
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
            $factory = FeatureFactory::make($app['config']['fez'])
                ->setLocaleResolver(static fn () => $app->getLocale())
                ->setRequestResolver(static fn () => $app['request'])
                ->setUrlResolver(static fn () => $app['url']);

            return FezManager::make(
                array_combine($features = Feature::enabled(), array_map([$factory, 'create'], $features))
            );
        });

        $this->app->alias('fez', FezManager::class);

        if ($this->app['config']['fez.finder.disabled']) {
            return;
        }

        $this->app->afterResolving('fez', static function (FezManager $fez, Application $app) {
            $route = $app['router']->current();

            // A route can be null if none was matched
            if (is_null($route)) {
                return;
            }

            $model = $route->metable();

            if (! is_null($model)) {
                $fez->for($model);
            }
        });
    }

    private function registerMacros()
    {
        MetableFinder::register();
        PropertySetter::register();
        RouteConfigurator::register();
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
