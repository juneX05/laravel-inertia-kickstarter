<?php

namespace Application\Modules\Core\User;

use App\Http\Controllers\Controller;
use Application\Modules\Core\Permissions\Permission_Model;
use Application\Modules\Core\Users\User_Model;
use Application\Modules\Core\Users\UserPermission_Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class Profile_Controller extends Controller
{
    public function render($component, $props)
    {
        return Inertia::render('Core/User/' . $component, $props);
    }

    public function profile() {
        abort_if(Gate::denies('user.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = Auth::id();
        $user = User_Model::where('id',$id)->first();
        $user_permissions = UserPermission_Model::where(['user_id' => $id, 'status' => 1])->pluck('permission_name')->toArray();
        $permissions = Permission_Model::all();
        return $this->render('Profile',compact('user','user_permissions','permissions'));
    }


}
