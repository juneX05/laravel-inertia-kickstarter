<?php

use Application\Modules\Configurations\SysConfigs\SysConfig_Controller;
use Illuminate\Support\Facades\Route;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/sys-configs', [SysConfig_Controller::class, 'index'])->name('viewSysConfigs');
    Route::get('/sys-configs/{id}/config', [SysConfig_Controller::class, 'show'])->name('viewSysConfig');

});
