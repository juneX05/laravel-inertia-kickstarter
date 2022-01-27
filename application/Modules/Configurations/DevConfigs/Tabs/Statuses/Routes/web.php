<?php

use Illuminate\Support\Facades\Route;
use Application\Modules\Configurations\DevConfigs\Tabs\Statuses\Controllers\StatusController;

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

    Route::get('/statuses', [StatusController::class,'index'])->name('viewStatuses');
    Route::get('/statuses/create', [StatusController::class,'create'])->name('createStatus');
    Route::post('/statuses/save', [StatusController::class,'store'])->name('saveStatus');
    Route::get('/statuses/{id}/edit', [StatusController::class,'edit'])->name('editStatus');
    Route::post('/statuses/delete', [StatusController::class,'destroy'])->name('deleteStatus');
    Route::post('/statuses/update', [StatusController::class,'update'])->name('updateStatus');

});
