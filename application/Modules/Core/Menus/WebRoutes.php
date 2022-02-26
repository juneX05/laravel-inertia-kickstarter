<?php

use Application\Modules\Core\Menus\Controllers\Menu_Controller;
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

    Route::get('/menus', [Menu_Controller::class,'index'])->name('viewMenus');
    Route::get('/menus/create', [Menu_Controller::class,'create'])->name('createMenu');
    Route::post('/menus/save', [Menu_Controller::class,'store'])->name('saveMenu');
    Route::get('/menus/{id}/edit', [Menu_Controller::class,'edit'])->name('editMenu');
    Route::post('/menus/delete', [Menu_Controller::class,'destroy'])->name('deleteMenu');
    Route::post('/menus/update', [Menu_Controller::class,'update'])->name('updateMenu');
    Route::get('/menus/manage-positions', [Menu_Controller::class,'managePositions'])->name('managePositions');
    Route::post('/menus/update-positions', [Menu_Controller::class,'updatePositions'])->name('updatePositions');

});
