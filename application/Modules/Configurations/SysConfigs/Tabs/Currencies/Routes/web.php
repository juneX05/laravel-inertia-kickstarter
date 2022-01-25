<?php

use Illuminate\Support\Facades\Route;
use Application\Modules\Configurations\SysConfigs\Tabs\Currencies\Controllers\CurrencyController;

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

    Route::get('/currencies', [CurrencyController::class,'index'])->name('viewCurrencies');
    Route::get('/currencies/create', [CurrencyController::class,'create'])->name('createCurrency');
    Route::post('/currencies/save', [CurrencyController::class,'store'])->name('saveCurrency');
    Route::get('/currencies/{id}/edit', [CurrencyController::class,'edit'])->name('editCurrency');
    Route::post('/currencies/delete', [CurrencyController::class,'destroy'])->name('deleteCurrency');
    Route::post('/currencies/update', [CurrencyController::class,'update'])->name('updateCurrency');

});
