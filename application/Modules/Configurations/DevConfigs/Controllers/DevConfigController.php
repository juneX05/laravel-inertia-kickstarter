<?php

namespace Application\Modules\Configurations\DevConfigs\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DevConfigController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dev_configs.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tabs = [
            
        ];

        return $this->render('Index', [
            'tabs' => $tabs,
            'default_tab' => ''
        ]);
    }

    public function render($component, $props)
    {
        return Inertia::render('Configurations/DevConfigs/Views/' . $component, $props);
    }

 

    public function show($id)
    {
        abort_if(Gate::denies('dev_config.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = [
            'items' => [],
            'headers' => [],
            'edit_route' => null,
            'delete_route' => null
        ];

//        if ($id == 'statuses') {
//            $data = [
//                'items' => Statuses::all(),
//                'headers' => [
//                    ['text' => 'SNO', 'value' => 'SNO', 'sortable' => false],
//                    ['text' => 'Name', 'align' => 'start', 'sortable' => true, 'value' => 'name',],
//                    ['text' => 'Actions', 'value' => 'actions', 'sortable' => false],
//                ],
//                'create_route' => 'createStatus',
//                'create_title' => 'Add Status',
//                'edit_route' => 'editStatus',
//                'delete_route' => 'deleteStatus'
//            ];
//        }

        return response()->json($data);
    }

}
