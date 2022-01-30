<?php

use Application\Modules\Configurations\SysConfigs\Controllers\SysConfigController;
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

    Route::get('/sys-configs', [SysConfigController::class, 'index'])->name('viewSysConfigs');
    Route::get('/sys-configs/{id}/config', [SysConfigController::class, 'show'])->name('viewSysConfig');

});
