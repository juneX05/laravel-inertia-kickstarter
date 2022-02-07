<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/generate', function () {
    $name = trim('   Project  ');
    $name = ucwords($name);
    $name = Str::remove(' ', $name);
    $data['moduleName'] = $name;

    $data['moduleType'] = 'System';
    $data['moduleIcon'] = 'mdi-tag';
    $data['relations'] = [
        [
            'type' => 'BelongsTo',
            'module' => 'ProjectStatus',
            'location' => 'DevConfigs',
            'column' => 'project_status_id',
            'display' => 'name',
        ],
    ];

    $data['columns'] = [
        [
            'display_name' => 'Name',
            'in_form' => true,
            'name' => 'name',
            'type' => 'string',
            'size' => 40,
            'not_null' => true,
            'default' => null,
            'unique' => true,
        ],
        [
            'display_name' => 'Description',
            'in_form' => true,
            'name' => 'description',
            'type' => 'text',
            'size' => null,
            'not_null' => false,
            'default' => null,
            'unique' => false,
        ],
        [
            'display_name' => 'Project Status',
            'in_form' => false,
            'name' => 'project_status_id',
            'type' => 'integer',
            'size' => null,
            'not_null' => true,
            'default' => null,
            'unique' => false,
        ],
    ];

    $moduleGenerator = new \Application\Generator\ModuleGenerator($data);
});*/
