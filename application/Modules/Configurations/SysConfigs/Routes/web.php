<?php

use Illuminate\Support\Facades\Route;
use Application\Modules\Configurations\SysConfigs\Controllers\ConfigurationController;

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

    Route::get('/configurations', [ConfigurationController::class, 'index'])->name('viewConfigurations');
    Route::get('/configurations/{id}/config', [ConfigurationController::class, 'show'])->name('viewConfiguration');

});
