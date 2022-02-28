<?php

namespace App\Http\Middleware;

use Application\Modules\Core\Permissions\Permission_Model;
use Application\Modules\Core\Users\UserPermission_Model;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthenticationGates
{
    public function handle($request, Closure $next)
    {

        $permissions = Permission_Model::all()->pluck('name')->toArray();
        $user_permissions = UserPermission_Model::where(['user_id' => Auth::id(), 'status' => 1])
            ->pluck('permission_name')->toArray();

//        dd(Auth::user());

        $user = Auth::user();
        if ($user) {
            foreach ($permissions as $permission) {
                Gate::define($permission, function ($user) use ($permission, $user_permissions){
                    return in_array($permission, $user_permissions);
                });
            }
        }

        return $next($request);
    }
}
