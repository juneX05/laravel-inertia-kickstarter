<?php

use Application\Modules\Configurations\DevConfigs\DevConfig_Controller;
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

    Route::get('/dev-configs', [DevConfig_Controller::class, 'index'])->name('viewDevConfigs');
    Route::get('/dev-configs/{id}/config', [DevConfig_Controller::class, 'show'])->name('viewDevConfig');

});
