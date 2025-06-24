<?php

namespace BladeSync\Laraauth\Providers;

use Illuminate\Support\ServiceProvider;
use BladeSync\Laraauth\Commands\InstallRoutesCommand;


class AuthPackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // ...
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'authpkg');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        if ($this->app->runningInConsole()) {
            
            $this->commands([
                InstallRoutesCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/../../config/authpkg.php' => config_path('authpkg.php'),
            ], 'authpkg-config');

            $this->publishes([
                __DIR__.'/../../resources/views' => resource_path('views/larauth'),
            ], 'authpkg-views');
            
            // ... etc.
        }
    }
    //...

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/authpkg.php', 'authpkg'
        );
    }
}