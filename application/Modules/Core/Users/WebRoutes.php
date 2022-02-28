<?php

use Application\Modules\Core\Users\User_Controller;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

    Route::get('/users', [User_Controller::class,'index'])->name('viewUsers');
    Route::get('/users/{id}/view', [User_Controller::class,'show'])->name('viewUser');
    Route::get('/users/create', [User_Controller::class,'create'])->name('createUser');
    Route::post('/users/save', [User_Controller::class,'store'])->name('saveUser');
    Route::get('/users/{id}/manage_user_permissions', [User_Controller::class,'manageUserPermissions'])->name('manageUserPermissions');
    Route::post('/users/save/user_permissions', [User_Controller::class,'saveUserPermissions'])->name('saveUserPermissions');
    Route::get('/users/{id}/edit', [User_Controller::class,'edit'])->name('editUser');
    Route::post('/users/delete', [User_Controller::class,'destroy'])->name('deleteUser');
    Route::post('/users/update', [User_Controller::class,'update'])->name('updateUser');
    Route::post('/users/update-status', [User_Controller::class,'updateStatus'])->name('updateUserStatus');
    Route::post('/users/reset/password', [User_Controller::class,'resetUserPassword'])->name('resetUserPassword');

});
