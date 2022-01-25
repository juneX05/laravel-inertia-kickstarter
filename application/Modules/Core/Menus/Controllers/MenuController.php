<?php

namespace Application\Modules\Core\Menus\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Application\Modules\Core\Menus\Models\Menu;
use Application\Modules\Core\Permissions\Models\Permission;

class MenuController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('menus.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = Menu::all(false);

        $core_modules = File::directories(base_path('application/Modules/Core'));
        $system_modules = File::directories(base_path('application/Modules/System'));
        $routes = Route::getRoutes();

        return $this->render('Index', [
            'data' => $data,
            'routes' => $routes,
            'core_modules' => $core_modules,
            'system_modules' => $system_modules
        ]);
    }

    public function render($component, $props) {
        return Inertia::render('Core/Menus/Views/' . $component, $props);
    }

    public function create() {
        abort_if(Gate::denies('menu.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::all(false);

        $core_modules = array_map(function ($module) {
            return str_replace(base_path('application/Modules/Core/'), '', $module);
        }, File::directories(base_path('application/Modules/Core')));

        $system_modules = array_map(function ($module) {
            return str_replace(base_path('application/Modules/System/'), '', $module);
        }, File::directories(base_path('application/Modules/System')));

        $routes = Route::getRoutes()->get();

        $permissions = Permission::all();


        return $this->render('Create', [
            'menus' => $menus,
            'routes' => $routes,
            'core_modules' => $core_modules,
            'system_modules' => $system_modules,
            'permissions' => $permissions
        ]);
    }

    public function edit($id) {
        abort_if(Gate::denies('menu.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $Menus = Menu::where('id',$id)->first();
        return $this->render('Edit', ['menu' => $Menus]);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('menu.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'name' => ['required'],
        ])->validate();

        Menu::create($request->all());

        return redirect()->back()
            ->with('message', 'Menus Created Successfully.');
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('menu.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'id' => ['required'],
            'name' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Menu::find($request->input('id'))->update($request->all());

            return redirect()->back()
                ->with('message', 'Menus Updated Successfully.');
        }
    }

    public function destroy(Request $request)
    {
        abort_if(Gate::denies('menu.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('id')) {
            Menu::find($request->input('id'))->delete();

            return redirect()->back();
        }
    }
}
