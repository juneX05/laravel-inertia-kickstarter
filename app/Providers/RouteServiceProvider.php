<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            $this->map();
        });
    }

    public function map() {
//        $directories = Storage::allDirectories(public_path('modules'));
        $core_directories = File::directories(base_path('modules/Core'));
        $system_directories = File::directories(base_path('modules/System'));
        $module_directories = array_merge($system_directories, $core_directories);

        foreach ($module_directories as $directory) {
            $web_route_file = $directory . '/Routes/web.php';
            $api_route_file = $directory . '/Routes/api.php';
            if (file_exists($web_route_file)) {
                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group($web_route_file);
            }

            if (file_exists($api_route_file)) {
                Route::middleware('api')
                    ->namespace($this->namespace)
                    ->group($api_route_file);
            }

        }
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
