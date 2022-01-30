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

        $modules = app('module_directories');

        $routes = Route::getRoutes();
        $view_data = array_merge([
            'data' => $data,
            'routes' => $routes,
        ], $modules);

        return $this->render('Index', $view_data);
    }

    public function render($component, $props) {
        return Inertia::render('Core/Menus/Views/' . $component, $props);
    }

    public function create() {
        abort_if(Gate::denies('menu.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::all(false);

//        $core_modules = array_map(function ($module) {
//            return str_replace(base_path('application/Modules/Core/'), '', $module);
//        }, File::directories(base_path('application/Modules/Core')));
//
//        $system_modules = array_map(function ($module) {
//            return str_replace(base_path('application/Modules/System/'), '', $module);
//        }, File::directories(base_path('application/Modules/System')));

        $routes = Route::getRoutes()->get();
        $modules = app('module_directories');
        $permissions = Permission::all();

        $view_data = array_merge([
            'menus' => $menus,
            'routes' => $routes,
            'permissions' => $permissions
        ], $modules);

        return $this->render('Create', $view_data);
    }

    public function managePositions() {
        abort_if(Gate::denies('menu.manage_positions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::all(false);

        return $this->render('ManagePositions', [
            'menus' => $menus,
        ]);
    }

    public function updatePositions(Request $request) {
        abort_if(Gate::denies('menu.manage_positions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = Validator::make($request->all(), [
            'menu_keys' => ['required', 'array'],
        ])->validate();

        $menu = new Menu();
        $menu->updateMenuPositions($data['menu_keys']);

        return redirect()->back()
            ->with('message', 'Menus Created Successfully.');
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
