<?php

use Application\Modules\Configurations\DevConfigs\Tabs\Statuses\Status_Controller;
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

    Route::get('/statuses', [Status_Controller::class,'index'])->name('viewStatuses');
    Route::get('/statuses/create', [Status_Controller::class,'create'])->name('createStatus');
    Route::post('/statuses/save', [Status_Controller::class,'store'])->name('saveStatus');
    Route::get('/statuses/{id}/edit', [Status_Controller::class,'edit'])->name('editStatus');
    Route::post('/statuses/delete', [Status_Controller::class,'destroy'])->name('deleteStatus');
    Route::post('/statuses/update', [Status_Controller::class,'update'])->name('updateStatus');

});
