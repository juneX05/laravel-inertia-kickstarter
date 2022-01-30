<?php

use Illuminate\Support\Facades\Route;
use Application\Modules\Core\Menus\Controllers\MenuController;

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

    Route::get('/menus', [MenuController::class,'index'])->name('viewMenus');
    Route::get('/menus/create', [MenuController::class,'create'])->name('createMenu');
    Route::post('/menus/save', [MenuController::class,'store'])->name('saveMenu');
    Route::get('/menus/{id}/edit', [MenuController::class,'edit'])->name('editMenu');
    Route::post('/menus/delete', [MenuController::class,'destroy'])->name('deleteMenu');
    Route::post('/menus/update', [MenuController::class,'update'])->name('updateMenu');
    Route::get('/menus/manage-positions', [MenuController::class,'managePositions'])->name('managePositions');
    Route::post('/menus/update-positions', [MenuController::class,'updatePositions'])->name('updatePositions');

});
