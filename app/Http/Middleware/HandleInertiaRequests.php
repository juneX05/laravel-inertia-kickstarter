<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Inertia\Middleware;
use Modules\Core\Users\Models\UserPermission;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'current_user_permissions' => UserPermission::where(['user_id' => Auth::id(), 'status' => 1])->pluck('permission_name')->toArray(),
            'APP_NAME' => env('APP_NAME'),
            'menus' => $this->getModuleMenus()
        ]);
    }

    private function getModuleMenus() {
        $menus = [];
        $core_directories = File::directories(base_path('modules/Core'));
        $system_directories = File::directories(base_path('modules/System'));
        $module_directories = array_merge($system_directories, $core_directories);

        foreach ($module_directories as $directory) {
            $menu_file = $directory . '/menu.php';
            if (file_exists($menu_file)) {
                $module_menu = require $menu_file;
               $menus = array_merge($menus, $module_menu);
            }
        }

//        dd($menus);
        return $menus;
    }
}
