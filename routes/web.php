<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::group(['middleware'=>'auth'],function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::group(['prefix'=>'users'],function(){
        Route::get('/index', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/add', [App\Http\Controllers\UserController::class, 'add'])->name('users.add');
        Route::post('/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    });
    Route::group(['prefix'=>'parcel'],function(){
        Route::get('/index', [App\Http\Controllers\ParcelController::class, 'index'])->name('parcel.index');
        Route::get('/add', [App\Http\Controllers\ParcelController::class, 'add'])->name('parcel.add');
        Route::post('/create', [App\Http\Controllers\ParcelController::class, 'create'])->name('parcel.create');
        Route::post('/create_parcel_process_ajax', [App\Http\Controllers\ParcelController::class, 'create_parcel_process_ajax'])->name('parcel.create_parcel_process_ajax');
    });



    Route::get('logout', [\App\Http\Controllers\UserController::class , 'logout'])->name('logout');

    Route::get('generate', function () {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        echo 'ok';
    });
    
});

Route::get('/privacy_policy', function () {
    return view('privacy_and_policy');
});

Route::get('/support', function () {
    return view('projects.support.support_page');
});

