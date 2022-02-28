<?php

namespace Application\Modules\Core\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Application\Modules\Core\Menus\Menu_Model;
use Application\Modules\Core\Permissions\Permission_Model;

class Menu_Controller extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('menus.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = Menu_Model::all(false);

        $modules = app('module_directories');

        $routes = Route::getRoutes();
        $view_data = array_merge([
            'data' => $data,
            'routes' => $routes,
        ], $modules);

        return $this->render('Index', $view_data);
    }

    public function render($component, $props) {
        return Inertia::render('Core/Menus/' . $component, $props);
    }

    public function create() {
        abort_if(Gate::denies('menu.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu_Model::getParentMenus();

        $routes_collection = collect(Route::getRoutes());

        $modules = Menu_Model::getModules();

        $permissions = Permission_Model::all();

//        $routes = $routes_collection->map( function ($item) {
//            return['uri' => $item->uri];
//        });

        $view_data = array_merge([
            'menus' => $menus,
            'permissions' => $permissions,
            'menu_types' => [
                ['id' => 'module_menu', 'name' => 'Module Menu'],
                ['id' => 'non_module_menu', 'name' => 'Non-Module Menu']
            ],
            'module_groups' => [
                ['id' => 'core', 'name' => 'Core Module'],
                ['id' => 'system', 'name' => 'System Module'],
//                ['id' => 'system_config', 'name' => 'System Config Module'],
//                ['id' => 'dev_config', 'name' => 'Developer Config Module'],
            ],
            'link_types' => [
                ['id' => 'hard', 'name' => 'Hard Link'],
                ['id' => 'route', 'name' => 'Route Link'],
            ],
        ], $modules);

        return $this->render('Create', $view_data);
    }

    public function managePositions() {
        abort_if(Gate::denies('menu.manage_positions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu_Model::all(false);

        return $this->render('ManagePositions', [
            'menus' => $menus,
        ]);
    }

    public function updatePositions(Request $request) {
        abort_if(Gate::denies('menu.manage_positions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = Validator::make($request->all(), [
            'menu_keys' => ['required', 'array'],
        ])->validate();

        $menu = new Menu_Model();
        $menu->updateMenuPositions($data['menu_keys']);

        return redirect()->back()
            ->with('message', 'Menus Created Successfully.');
    }

    public function edit($id) {
        abort_if(Gate::denies('menu.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $Menus = Menu_Model::where('id',$id)->first();
        return $this->render('Edit', ['menu' => $Menus]);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('menu.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'name' => ['required'],
            'title' => ['required'],
            'icon' => ['required'],
            'link' => ['required'],
            'menu_type' => ['required'],
            'position' => ['required'],
            'permissions' => ['nullable'],
            'module_group' => ['nullable'],
            'module' => ['nullable'],
        ],[
            'permissions.required' => 'Please select at-least one permission'
        ])->validate();

        Menu_Model::create($request->all());

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
            Menu_Model::find($request->input('id'))->update($request->all());

            return redirect()->back()
                ->with('message', 'Menus Updated Successfully.');
        }
    }

    public function destroy(Request $request)
    {
        abort_if(Gate::denies('menu.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('id')) {
            Menu_Model::find($request->input('id'))->delete();

            return redirect()->back();
        }
    }
}
