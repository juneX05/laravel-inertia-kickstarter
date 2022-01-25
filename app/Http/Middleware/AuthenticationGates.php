<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Application\Modules\Core\Permissions\Models\Permission;
use Application\Modules\Core\Users\Models\UserPermission;

class AuthenticationGates
{
    public function handle($request, Closure $next)
    {

        $permissions = Permission::all()->pluck('name')->toArray();
        $user_permissions = UserPermission::where(['user_id' => Auth::id(), 'status' => 1])
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
