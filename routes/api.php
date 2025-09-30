<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/login', 'api\Auth@login');
Route::post('auth/register', 'api\Auth@register');
Route::get('auth/getUserData', 'api\Auth@getDataUser');

Route::get('masterdata/kota', 'api\MasterData@masterDataKota');
Route::get('masterdata/provinsi', 'api\MasterData@masterDataProvinsi');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
