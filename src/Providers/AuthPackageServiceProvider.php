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
        // View loading logic (theek hai)
        $customPath = resource_path('views/laraauth');
        if (is_dir($customPath)) {
            $this->loadViewsFrom($customPath, 'laraauth');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laraauth');

        // Migrations loading (theek hai)
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // --- YAHAN SAARI LOGIC THEEK KI GAYI HAI ---
        if ($this->app->runningInConsole()) {
            
            // Step 1: Dono commands ko sirf yahan register karein
            $this->commands([
                InstallCommand::class,
                InstallRoutesCommand::class,
            ]);

            // Step 2: Har jagah 'laraauth' ka naam istemal karein
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
        // Step 3: Yahan bhi 'laraauth' ka naam istemal karein
        $this->mergeConfigFrom(
            __DIR__.'/../../config/laraauth.php', 'laraauth'
        );
    }
}
