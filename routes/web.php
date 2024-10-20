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
        Route::get('edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::post('update', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    });
    Route::group(['prefix'=>'parcel'],function(){
        Route::get('/index', [App\Http\Controllers\ParcelController::class, 'index'])->name('parcel.index');
        Route::get('/add', [App\Http\Controllers\ParcelController::class, 'add'])->name('parcel.add');
        Route::post('/create', [App\Http\Controllers\ParcelController::class, 'create'])->name('parcel.create');
        Route::get('/delete_parcel/{id}', [App\Http\Controllers\ParcelController::class, 'delete_parcel'])->name('parcel.delete_parcel');
        Route::post('/create_parcel_process_ajax', [App\Http\Controllers\ParcelController::class, 'create_parcel_process_ajax'])->name('parcel.create_parcel_process_ajax');
        Route::post('/collection_excel', [App\Http\Controllers\ParcelController::class, 'collection_excel'])->name('parcel.collection_excel');
        Route::post('/returned_excel', [App\Http\Controllers\ParcelController::class, 'returned_excel'])->name('parcel.returned_excel');
        Route::post('/switch_excel', [App\Http\Controllers\ParcelController::class, 'switch_excel'])->name('parcel.switch_excel');
        Route::get('/delete/{id}', [App\Http\Controllers\ParcelController::class, 'delete'])->name('parcel.delete');
        Route::get('/add_collection_page', [App\Http\Controllers\ParcelController::class, 'add_collection_page'])->name('parcel.add_collection_page');
        Route::get('/add_return_page', [App\Http\Controllers\ParcelController::class, 'add_return_page'])->name('parcel.add_return_page');
        Route::get('/add_switch_page', [App\Http\Controllers\ParcelController::class, 'add_switch_page'])->name('parcel.add_switch_page');
        Route::post('/create_parcel_process', [App\Http\Controllers\ParcelController::class, 'create_parcel_process'])->name('parcel.create_parcel_process');
        Route::post('/confirm_add_parcel_process', [App\Http\Controllers\ParcelController::class, 'confirm_add_parcel_process'])->name('parcel.confirm_add_parcel_process');
    });
    
    Route::group(['prefix'=>'report'],function(){
        Route::get('/index', [App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
        Route::post('/report_list', [App\Http\Controllers\ReportController::class, 'report_list'])->name('report.report_list');
        Route::post('/report_excel', [App\Http\Controllers\ReportController::class, 'report_excel'])->name('report.report_excel');
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

