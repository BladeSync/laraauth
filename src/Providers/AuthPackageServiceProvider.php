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
        // Step 1: General resources load karna
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Step 2: Views ko load karna (custom path ki aqlmand logic ke saath)
        $customPath = resource_path('views/laraauth');
        if (is_dir($customPath)) {
            $this->loadViewsFrom($customPath, 'laraauth');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laraauth');

        // Step 3: Sirf console mein chalne wale kaam handle karna
        if ($this->app->runningInConsole()) {
            
            // Commands register karna
            $this->commands([
                InstallCommand::class,
                InstallRoutesCommand::class,
            ]);

            // Assets publish karna (saaf suthre tags ke saath)
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
        // Config file ko theek naam se merge karna
        $this->mergeConfigFrom(
            __DIR__.'/../../config/laraauth.php', 'laraauth'
        );
    }
}
