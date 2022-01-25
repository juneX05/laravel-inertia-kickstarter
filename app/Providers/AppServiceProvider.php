<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Application\ModulesCore\Users\Models\UserPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $core_directories = File::directories(base_path('application/Modules/Core'));
        $system_directories = File::directories(base_path('application/Modules/System'));

        $module_configurations = File::directories(base_path('application/Modules/Configurations'));
        $configurations = File::directories(base_path('application/Modules/Configurations/SysConfigs/Tabs'));
        $statuses = File::directories(base_path('application/Modules/Configurations/DevConfigs/Tabs'));
        $module_directories = array_merge($system_directories, $core_directories, $statuses, $module_configurations, $configurations);

        $migrations_folders = [];
        foreach ($module_directories as $directory) {
            if (is_dir($directory . "/Migrations")) {
                $migrations_folders[] = $directory . "/Migrations";
            }
            if (is_dir($directory . "/Migrations")) {
                $seeders_folders[] = $directory . "/Seeders";
            }
        }
        $this->loadMigrationsFrom($migrations_folders);
    }
}
