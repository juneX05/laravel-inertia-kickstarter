<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Application\Modules\Core\Users\Controllers\UserController;

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

    Route::get('/users', [UserController::class,'index'])->name('viewUsers');
    Route::get('/users/create', [UserController::class,'create'])->name('createUser');
    Route::post('/users/save', [UserController::class,'store'])->name('saveUser');
    Route::get('/users/{id}/manage_user_permissions', [UserController::class,'manageUserPermissions'])->name('manageUserPermissions');
    Route::post('/users/save/user_permissions', [UserController::class,'saveUserPermissions'])->name('saveUserPermissions');
    Route::get('/users/{id}/edit', [UserController::class,'edit'])->name('editUser');
    Route::post('/users/delete', [UserController::class,'destroy'])->name('deleteUser');
    Route::post('/users/update', [UserController::class,'update'])->name('updateUser');
    Route::post('/users/reset/password', [UserController::class,'resetUserPassword'])->name('resetUserPassword');

});
