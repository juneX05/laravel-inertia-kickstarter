<?php

namespace App\Http\Middleware;

use Application\Modules\Core\Menus\Menu_Model;
use Application\Modules\Core\Users\UserPermission_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;

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
            'current_user_permissions' => UserPermission_Model::where(['user_id' => Auth::id(), 'status' => 1])->pluck('permission_name')->toArray(),
            'APP_NAME' => env('APP_NAME'),
            'sidebar_links' => Menu_Model::all(),
            'menu_keys' => Menu_Model::getKeys(),
            'current_route' => Route::getCurrentRoute()->action['as'],
            'error' => [],
        ];
        return array_merge(parent::share($request), $data);
    }


}
