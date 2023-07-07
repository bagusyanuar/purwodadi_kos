<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'admin'], function (){

    Route::group(['prefix' => 'pengguna'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('admin.pengguna');
        Route::post('/{id}', [\App\Http\Controllers\Admin\PenggunaController::class, 'patch'])->name('admin.pengguna.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('admin.pengguna.delete');
    });

    Route::group(['prefix' => 'pemilik-kos'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\PemilikKosController::class, 'index'])->name('admin.pemilik-kos');
        Route::post('/{id}', [\App\Http\Controllers\Admin\PemilikKosController::class, 'patch'])->name('admin.pemilik-kos.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\PemilikKosController::class, 'destroy'])->name('admin.pemilik-kos.delete');
    });


});
