<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Application\Modules\Core\Menus\Models\Menu;
use Application\Modules\Core\Users\Models\UserPermission;

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
        $data = [
            'current_user_permissions' => UserPermission::where(['user_id' => Auth::id(), 'status' => 1])->pluck('permission_name')->toArray(),
            'APP_NAME' => env('APP_NAME'),
            'sidebar_links' => Menu::all(),
            'menu_keys' => Menu::getKeys(),
            'error' => [],
        ];
        return array_merge(parent::share($request), $data);
    }


}
