<?php

namespace BladeSync\Laraauth\Providers;

use Illuminate\Support\ServiceProvider;
use BladeSync\Laraauth\Commands\InstallCommand;
use BladeSync\Laraauth\Commands\InstallRoutesCommand;

class AuthPackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $customPath = resource_path('views/laraauth');
        if (is_dir($customPath)) {
            $this->loadViewsFrom($customPath, 'laraauth');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laraauth');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        if ($this->app->runningInConsole()) {
            
            $this->commands([
                InstallCommand::class,
                InstallRoutesCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/../../config/laraauth.php' => config_path('laraauth.php'),
            ], 'laraauth-config');

            $this->publishes([
                __DIR__.'/../../resources/views' => resource_path('views/laraauth'),
            ], 'laraauth-views');
            
            $this->publishes([
                __DIR__.'/../../resources/views/dashboard/home.blade.php' => resource_path('views/home.blade.php'),
            ], 'laraauth-home');

            $this->publishes([
                 __DIR__.'/../../database/migrations/' => database_path('migrations')
            ], 'laraauth-migrations');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/laraauth.php', 'laraauth'
        );
    }
}
