<?php

use Application\Modules\Configurations\SysConfigs\Tabs\Currencies\Currency_Controller;
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

Route::middleware(['auth:sanctum', 'verified'])
    ->prefix('/sys-configs')
    ->group(function () {
        Route::get('/currencies', [Currency_Controller::class,'index'])->name('viewCurrencies');
        Route::get('/currencies/create', [Currency_Controller::class,'create'])->name('createCurrency');
        Route::post('/currencies/save', [Currency_Controller::class,'store'])->name('saveCurrency');
        Route::get('/currencies/{id}/edit', [Currency_Controller::class,'edit'])->name('editCurrency');
        Route::post('/currencies/delete', [Currency_Controller::class,'destroy'])->name('deleteCurrency');
        Route::post('/currencies/update', [Currency_Controller::class,'update'])->name('updateCurrency');
});
