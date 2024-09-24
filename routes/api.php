<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[\App\Http\Controllers\api\AuthController::class , 'login']);

Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::group(['prefix'=>'parcel'],function(){
        Route::post('/parcel_list',[\App\Http\Controllers\api\ParcelController::class , 'parcel_list']);
        Route::post('/create',[\App\Http\Controllers\api\ParcelController::class , 'create']);
        Route::post('/create_parcel_process',[\App\Http\Controllers\api\ParcelController::class , 'create_parcel_process']);
        Route::post('/create_parcel_process_anyway',[\App\Http\Controllers\api\ParcelController::class , 'create_parcel_process_anyway']);
    });
    Route::post('/upload',[\App\Http\Controllers\api\ImageUploadController::class , 'upload']);
});
