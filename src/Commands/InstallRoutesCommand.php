<?php

namespace BladeSync\Laraauth\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'authpkg:install-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the auth routes by copying them to the application\'s web.php file. WARNING: This will overwrite existing routes.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->confirm('This will overwrite your existing routes/web.php file. Do you wish to continue?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $packageRoutesPath = __DIR__.'/../routes/web.php';

        $appRoutesPath = base_path('routes/web.php');

        if (File::exists($packageRoutesPath)) {
            $routesContent = File::get($packageRoutesPath);
            File::put($appRoutesPath, $routesContent);
            $this->info('Auth routes installed successfully. Your routes/web.php has been overwritten.');
        } else {
            $this->error('Package route file not found at: ' . $packageRoutesPath);
            return 1;
        }

        return 0;
    }
}