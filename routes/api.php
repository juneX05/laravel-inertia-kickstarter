<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/generate', function (Request  $request) {

    $file = $request->file('module');
    $content = file_get_contents($file->getRealPath());
    $data = json_decode($content, true);

    $module_generator = new \Application\Generator\ModuleGenerator($data);
dd($data);
});
