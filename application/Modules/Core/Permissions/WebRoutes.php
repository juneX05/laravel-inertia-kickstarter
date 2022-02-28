<?php

use Application\Modules\Core\Permissions\Permission_Controller;
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

    Route::get('/permissions', [Permission_Controller::class,'index'])->name('viewPermissions');
    Route::get('/permissions/create', [Permission_Controller::class,'create'])->name('createPermission');
    Route::post('/permissions/save', [Permission_Controller::class,'store'])->name('savePermission');
    Route::get('/permissions/manage_user_permissions', [Permission_Controller::class,'manageUsersPermissions'])->name('manageUsersPermissions');
    Route::post('/permissions/save/user_permissions', [Permission_Controller::class,'saveUsersPermissions'])->name('saveUsersPermissions');
    Route::post('/permissions/get_user_permissions', [Permission_Controller::class,'userPermissions'])->name('getUserPermissions');
    Route::get('/permissions/{id}/edit', [Permission_Controller::class,'edit'])->name('editPermission');
    Route::post('/permissions/delete', [Permission_Controller::class,'destroy'])->name('deletePermission');
    Route::post('/permissions/update', [Permission_Controller::class,'update'])->name('updatePermission');

});
