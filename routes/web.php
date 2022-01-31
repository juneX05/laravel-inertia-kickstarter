<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \Illuminate\Support\Str;

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

Route::get('/generate', function () {
    $name = trim('   Payment Status  ');
    $name = ucwords($name);
    $name = Str::remove(' ', $name);
    $data['moduleName'] = $name;

    $data['moduleType'] = 'DevConfigs';
    $data['moduleIcon'] = 'mdi-tag';
    $data['relations'] = [
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
            'display_name' => 'Color',
            'in_form' => true,
            'name' => 'color',
            'type' => 'string',
            'size' => null,
            'not_null' => false,
            'default' => null,
            'unique' => false,
        ],
    ];

    $moduleGenerator = new \Application\Generator\ModuleGenerator($data);
});



//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->name('dashboard');
