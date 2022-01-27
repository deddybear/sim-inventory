<?php

use App\Http\Controllers\GudangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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



Auth::routes();

Route::get('/', function (){
    return redirect('/dashboard');
});

Route::get('/password', function (){
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/gudang', [GudangController::class, 'index']);
        Route::get('/laporan', [LaporanController::class, 'index']);

        Route::middleware(['divisi'])->group(function () {
            Route::get('/karyawan', [KaryawanController::class, 'index']);
        });

    });

    
});