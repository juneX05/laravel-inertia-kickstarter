<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Application\Modules\Core\Permissions\Controllers\PermissionController;

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

    Route::get('/permissions', [PermissionController::class,'index'])->name('viewPermissions');
    Route::get('/permissions/create', [PermissionController::class,'create'])->name('createPermission');
    Route::post('/permissions/save', [PermissionController::class,'store'])->name('savePermission');
    Route::get('/permissions/manage_user_permissions', [PermissionController::class,'manageUsersPermissions'])->name('manageUsersPermissions');
    Route::post('/permissions/save/user_permissions', [PermissionController::class,'saveUsersPermissions'])->name('saveUsersPermissions');
    Route::post('/permissions/get_user_permissions', [PermissionController::class,'userPermissions'])->name('getUserPermissions');
    Route::get('/permissions/{id}/edit', [PermissionController::class,'edit'])->name('editPermission');
    Route::post('/permissions/delete', [PermissionController::class,'destroy'])->name('deletePermission');
    Route::post('/permissions/update', [PermissionController::class,'update'])->name('updatePermission');

});
