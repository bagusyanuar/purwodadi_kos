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

Route::get('/', [\App\Http\Controllers\Guest\HomeController::class, 'index'])->name('home');
Route::get('/pencarian', [\App\Http\Controllers\Guest\PencarianController::class, 'index'])->name('pencarian');

Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'admin'], function (){

    Route::group(['prefix' => 'pengguna'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('admin.pengguna');
        Route::post('/{id}', [\App\Http\Controllers\Admin\PenggunaController::class, 'patch'])->name('admin.pengguna.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('admin.pengguna.delete');
    });

    Route::group(['prefix' => 'wilayah'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\WilayahController::class, 'index'])->name('admin.wilayah');
        Route::post('/{id}', [\App\Http\Controllers\Admin\WilayahController::class, 'patch'])->name('admin.wilayah.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\WilayahController::class, 'destroy'])->name('admin.wilayah.delete');
    });

    Route::group(['prefix' => 'pemilik-kos'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\PemilikKosController::class, 'index'])->name('admin.pemilik-kos');
        Route::post('/{id}', [\App\Http\Controllers\Admin\PemilikKosController::class, 'patch'])->name('admin.pemilik-kos.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\PemilikKosController::class, 'destroy'])->name('admin.pemilik-kos.delete');
    });

    Route::group(['prefix' => 'fasilitas-umum'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\FasilitasUmumController::class, 'index'])->name('admin.fasilitas-umum');
        Route::post('/{id}', [\App\Http\Controllers\Admin\FasilitasUmumController::class, 'patch'])->name('admin.fasilitas-umum.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\FasilitasUmumController::class, 'destroy'])->name('admin.fasilitas-umum.delete');
    });

    Route::group(['prefix' => 'fasilitas-kamar'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\FasilitasKamarController::class, 'index'])->name('admin.fasilitas-kamar');
        Route::post('/{id}', [\App\Http\Controllers\Admin\FasilitasKamarController::class, 'patch'])->name('admin.fasilitas-kamar.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\FasilitasKamarController::class, 'destroy'])->name('admin.fasilitas-kamar.delete');
    });

    Route::group(['prefix' => 'peraturan'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\PeraturanController::class, 'index'])->name('admin.peraturan');
        Route::post('/{id}', [\App\Http\Controllers\Admin\PeraturanController::class, 'patch'])->name('admin.peraturan.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\PeraturanController::class, 'destroy'])->name('admin.peraturan.delete');
    });

    Route::group(['prefix' => 'kos'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\KosController::class, 'index'])->name('admin.kos');
        Route::post('/{id}', [\App\Http\Controllers\Admin\KosController::class, 'patch'])->name('admin.kos.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\KosController::class, 'destroy'])->name('admin.kos.delete');
    });

    Route::group(['prefix' => 'kamar'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\Admin\KamarController::class, 'index'])->name('admin.kamar');
        Route::post('/{id}', [\App\Http\Controllers\Admin\KamarController::class, 'patch'])->name('admin.kamar.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\KamarController::class, 'destroy'])->name('admin.kamar.delete');
        Route::match(['post', 'get'],'/{id}/images', [\App\Http\Controllers\Admin\KamarController::class, 'images'])->name('admin.kamar.images');
        Route::post('/{id}/drop-images', [\App\Http\Controllers\Admin\KamarController::class, 'dropImages'])->name('admin.kamar.drop.images');
    });


});
