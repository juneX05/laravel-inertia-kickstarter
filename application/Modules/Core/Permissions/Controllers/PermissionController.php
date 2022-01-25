<?php

namespace Application\Modules\Core\Permissions\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Application\Modules\Core\Permissions\Models\Permission;
use Application\Modules\Core\Users\Models\User;
use Application\Modules\Core\Users\Models\UserPermission;

class PermissionController extends Controller
{
    public function render($component, $props)
    {
        return Inertia::render('Core/Permissions/Views/' . $component, $props);
    }

    public function index()
    {
        abort_if(Gate::denies('permissions.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = Permission::all();

        return $this->render('Index', ['data' => $data]);
    }

    public function create() {
        abort_if(Gate::denies('permission.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $this->render('Create', []);
    }

    public function edit($id) {
        abort_if(Gate::denies('permission.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission = Permission::where('id',$id)->first();
        return $this->render('Edit', ['permission' => $permission]);
    }

    public function manageUsersPermissions() {
        abort_if(Gate::denies('permission.manage.users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users= User::all();
        $permissions = Permission::all();
        return $this->render('ManageUsersPermissions', [
            'users' => $users,
            'permissions' => $permissions,
            ]);
    }

    public function userPermissions(Request $request) {
        abort_if(Gate::denies('permission.manage.users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_permissions = UserPermission::where(['user_id' => $request->user_id, 'status' => 1])->pluck('permission_name')->toArray();

        return response() -> json([
            'user_permissions' => $user_permissions,
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('permission.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'name' => ['required'],
            'title' => ['required'],
        ])->validate();

        Permission::create($request->all());

        return redirect()->back()
            ->with('message', 'Permission Created Successfully.');
    }

    public function saveUsersPermissions(Request $request)
    {
        abort_if(Gate::denies('permission.manage.users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'user_id' => ['required'],
            'permission_names' => [],
        ])->validate();

        $permission_names = $request->permission_names;
        $user_id = $request->user_id;

        //disable all user permissions
        UserPermission::where('user_id', $user_id)
            ->update(['status' => 0]);

        //enable permissions sent
        foreach ($permission_names as $permission_name) {
            UserPermission::updateOrCreate(
                ['user_id' => $user_id, 'permission_name' => $permission_name],
                ['status' => 1]
            );
        }

        return redirect()->back()
            ->with(['message' => 'Permissions Synced Successfully.', ]);
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('permission.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'id' => ['required'],
            'title' => ['required'],
            'name' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Permission::find($request->input('id'))->update($request->all());

            return redirect()->back()
                ->with('message', 'Permission Updated Successfully.');
        }
    }

    public function destroy(Request $request)
    {
        abort_if(Gate::denies('permission.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('id')) {
            Permission::find($request->input('id'))->delete();

            return redirect()->back();
        }
    }
}
