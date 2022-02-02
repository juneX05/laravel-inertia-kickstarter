<?php


namespace Application;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    private function applicationModuleDirectories() {
        return [
            'core_modules' => 'application/Modules/Core',
            'system_modules' => 'application/Modules/System',
            'configuration_modules' => 'application/Modules/Configurations',
            'system_configs_modules' => 'application/Modules/Configurations/SysConfigs/Tabs',
            'dev_configs_modules' => 'application/Modules/Configurations/DevConfigs/Tabs',
        ];
    }

    public function getApplicationModules() {
        $module_directories = $this->applicationModuleDirectories();
        $modules = [];
        foreach ($module_directories as $key => $directory) {
            $modules[$key] = File::directories(base_path($directory));
        }
        return $modules;
    }

    public function getApplicationModulesList() {
        $module_directories = $this->applicationModuleDirectories();
        $modules = [];
        foreach ($module_directories as $key => $directory) {
            $modules = array_merge($modules, File::directories(base_path($directory)));
        }
        return $modules;
    }

    public function boot()
    {
            $this->app->singleton('module_directories', function(){
                return $this->getApplicationModules();
            });

            $this->app->singleton('module_directories_list', function(){
                return $this->getApplicationModulesList();
            });

//            // If you use this line of code then it'll be available in any view
//            // as $site_settings but you may also use app('site_settings') as well
//            View::share('site_settings', app('site_settings'));


        $this->migrationsMap();
        $this->routesMap();
    }

    public function register()
    {
        //
    }

    private function migrationsMap() {
        $module_directories = $this->getApplicationModulesList();

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

    private function routesMap() {
       $module_directories = $this->getApplicationModulesList();

        foreach ($module_directories as $directory) {
            $this->getRoutes($directory);
        }

        $this->getRoutes(base_path('/application'));
    }

    private function getRoutes($directory) {
        $web_route_file = $directory . '/Routes/web.php';
        $api_route_file = $directory . '/Routes/api.php';
        if (file_exists($web_route_file)) {
            Route::middleware('web')
                ->namespace(null)
                ->group($web_route_file);
        }

        if (file_exists($api_route_file)) {
            Route::middleware('api')
                ->namespace(null)
                ->group($api_route_file);
        }
    }
}