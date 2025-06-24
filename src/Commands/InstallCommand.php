<?php

namespace BladeSync\Laraauth\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraauth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all Laraauth resources like routes, views, and run migrations.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->comment('Publishing Laraauth Configuration...');
        Artisan::call('vendor:publish', ['--tag' => 'laraauth-config', '--force' => true]);

        $this->comment('Publishing Laraauth Home Page View...');
        Artisan::call('vendor:publish', ['--tag' => 'laraauth-home', '--force' => true]);
        
        $this->info('Laraauth configuration and home page published successfully.');

        if ($this->confirm('Do you want to install the routes file? This will overwrite your existing routes/web.php.', true)) {
            Artisan::call('laraauth:install-routes', ['--force' => true]);
            $this->info('Routes installed successfully.');
        }

        if ($this->confirm('Do you want to run the database migrations? This will run ALL pending migrations.', true)) {
            Artisan::call('migrate');
            $this->info('Database migrated successfully.');
        }

        $this->info('Laraauth has been installed successfully! Enjoy!');
        return 0;
    }
}