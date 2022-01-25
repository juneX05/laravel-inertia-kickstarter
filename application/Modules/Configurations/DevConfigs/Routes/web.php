<?php

use Illuminate\Support\Facades\Route;
use Application\Modules\Configurations\DevConfigs\Controllers\DevConfigController;

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

    Route::get('/dev-configs', [DevConfigController::class, 'index'])->name('viewDevConfigs');
    Route::get('/dev-configs/{id}/config', [DevConfigController::class, 'show'])->name('viewDevConfig');

});
