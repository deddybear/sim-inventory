<?php

use App\Http\Controllers\GudangController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisBahanBakuController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    //view
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/gudang', [GudangController::class, 'index']);
        Route::get('/laporan', [LaporanController::class, 'index']);
        Route::get('/history/out', [HistoryController::class, 'index']);
        Route::get('/history/in', [HistoryController::class, 'index']);
        Route::get('/types', [JenisBahanBakuController::class, 'index']);
        Route::get('/units', [UnitsController::class, 'index']);
        Route::get('/akun/edit', [UserController::class, 'pageEditAkun']);

        Route::middleware(['divisi'])->group(function () {
            Route::get('/karyawan', [UserController::class, 'index']);
        });

    });

    //fungsional 
    Route::prefix('gudang')->group(function () {
        Route::get('/data', [GudangController::class, 'data']);
        Route::get('/search', [GudangController::class, 'search']);
        Route::post('/create', [GudangController::class, 'create']);
        Route::put('/update/{id}', [GudangController::class, 'update']);
        Route::get('/add/{stock}/{id}', [GudangController::class, 'addingStock']);
        Route::get('/reduce/{stock}/{id}', [GudangController::class, 'reduceStock']);
        Route::delete('/delete/{id}', [GudangController::class, 'destroy']);
    });

    Route::prefix('type')->group(function () {
        Route::get('/data', [JenisBahanBakuController::class, 'data']);
        Route::get('/search', [JenisBahanBakuController::class, 'search']);
        Route::post('/create', [JenisBahanBakuController::class, 'create']);
        Route::put('/update/{id}', [JenisBahanBakuController::class, 'update']);
        Route::delete('/delete/{id}', [JenisBahanBakuController::class, 'destroy']);
    });

    Route::prefix('unit')->group(function () {
        Route::get('/data', [UnitsController::class, 'data']);
        Route::get('/search', [UnitsController::class, 'search']);
        Route::post('/create', [UnitsController::class, 'create']);
        Route::put('/update/{id}', [UnitsController::class, 'update']);
        Route::delete('/delete/{id}', [UnitsController::class, 'destroy']);
    });

    Route::prefix('history')->group(function () {
        Route::get('/data/{params}', [HistoryController::class, 'data']);
        Route::get('/search', [HistoryController::class, 'search']);
        Route::delete('/rollback/{id}', [HistoryController::class, 'rollback']);
        Route::delete('/delete/{params}', [HistoryController::class, 'destroy']);

    });

    Route::prefix('laporan')->group(function () {
        Route::post('/', [LaporanController::class, 'downloadLaporan']);
    });

    Route::prefix('karyawan')->group(function () {
        Route::get('/data', [UserController::class, 'data']);
        Route::get('/search', [UserController::class, 'search']);
        Route::post('/create', [UserController::class, 'create']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    });


});