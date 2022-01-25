<?php

namespace Application\Modules\Core\Users\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Application\Modules\Core\Permissions\Models\Permission;
use Application\Modules\Core\Users\Models\User;
use Application\Modules\Core\Users\Models\UserPermission;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function render($component, $props)
    {
        return Inertia::render('Core/Users/Views/' . $component, $props);
    }

    public function index()
    {
        abort_if(Gate::denies('users.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = User::all();

        return $this->render('Index', ['data' => $data]);
    }

    public function create() {
        abort_if(Gate::denies('user.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $this->render('Create', []);
    }

    public function edit($id) {
        abort_if(Gate::denies('user.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::where('id',$id)->first();
        return $this->render('Edit', ['data' => $user]);
    }

    public function manageUserPermissions($id) {
        abort_if(Gate::denies('user.manage.user.permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_permissions = UserPermission::where(['user_id' => $id, 'status' => 1])->pluck('permission_name')->toArray();
        $permissions = Permission::all();
        $user = User::where('id',$id)->first();
        return $this->render('ManageUserPermissions', [
            'data' => $user,
            'user_permissions' => $user_permissions,
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('user.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
            ]);

        $result = User::create($request->all());

        return redirect()->back()
            ->with('message', 'User Created Successfully.');
    }

    public function saveUserPermissions(Request $request)
    {
        abort_if(Gate::denies('user.manage.user.permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            ->with(['message' => 'User Permissions Synced Successfully.', ]);
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('user.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'id' => ['required'],
            'email' => ['required'],
            'name' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            User::find($request->input('id'))->update($request->all());

            return redirect()->back()
                ->with('message', 'User Updated Successfully.');
        }
    }

    public function resetUserPassword(Request $request)
    {
        abort_if(Gate::denies('user.reset.password'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'password' => $this->passwordRules(),
        ])->validate();

        if ($request->has('id')) {
            User::find($request->input('id'))->update(
                ['password' => Hash::make($request->input('password'))]
            );

            return redirect()->back()
                ->with('message', 'User Updated Successfully.');
        }
    }

    public function destroy(Request $request)
    {
        abort_if(Gate::denies('user.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('id')) {
            User::find($request->input('id'))->delete();

            return redirect()->back();
        }
    }
}
