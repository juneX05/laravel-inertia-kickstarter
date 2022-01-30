<?php

namespace Application\Modules\Configurations\SysConfigs\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SysConfigController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sys_configs.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tabs = [
            ['title' => 'Amenities', 'key' => 'amenities'],
            ['title' => 'Currencies', 'key' => 'currencies'],
            ['title' => 'Booking Sources', 'key' => 'booking_sources'],
            ['title' => 'Room Prices', 'key' => 'room_prices'],
        ];

        return $this->render('Index', [
            'tabs' => $tabs,
            'default_tab' => 'amenities'
        ]);
    }

    public function render($component, $props)
    {
        return Inertia::render('Configurations/SysConfigs/Views/' . $component, $props);
    }

    
    public function show($id)
    {
        abort_if(Gate::denies('sys_config.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = [
            'items' => [],
            'headers' => [],
            'edit_route' => null,
            'delete_route' => null
        ];

        

//        if ($id == 'currencies') {
//            $data = [
//                'items' => Currency::all(),
//                'headers' => [
//                    ['text' => 'SNO', 'value' => 'SNO', 'sortable' => false],
//                    ['text' => 'Name', 'align' => 'start', 'sortable' => true, 'value' => 'name',],
//                    ['text' => 'Abbreviation', 'align' => 'start', 'sortable' => true, 'value' => 'abbreviation',],
//                    ['text' => 'Symbol', 'align' => 'start', 'sortable' => true, 'value' => 'symbol',],
//                    ['text' => 'Actions', 'value' => 'actions', 'sortable' => false],
//                ],
//                'create_route' => 'createCurrency',
//                'create_title' => 'Add Currency',
//                'edit_route' => 'editCurrency',
//                'delete_route' => 'deleteCurrency'
//            ];
//        }

        

        return response()->json($data);
    }

}
