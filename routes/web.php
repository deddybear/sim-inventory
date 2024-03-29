<?php

use App\Http\Controllers\GudangController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisBahanBakuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\UserController;
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
    //view
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::prefix('bahan-baku')->group(function () {
            Route::get('/gudang', [GudangController::class, 'index']);
            Route::get('/types', [JenisBahanBakuController::class, 'index']);
            Route::get('/units', [UnitsController::class, 'index']);
            Route::get('/rack', [RackController::class, 'index'])->name('rack');
        });

        Route::prefix('history')->group(function () {
            Route::get('/out', [HistoryController::class, 'index']);
            Route::get('/in', [HistoryController::class, 'index']);
        });
        Route::get('/laporan', [LaporanController::class, 'index']);

        Route::prefix('akun')->group(function () {
            Route::get('/edit', [UserController::class, 'pageEditAkun']);
            Route::middleware(['divisi'])->group(function () {
                Route::get('/karyawan', [UserController::class, 'index']);
            });
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

    Route::prefix('rack')->group(function () {
        Route::get('/data', [RackController::class, 'data']);
        Route::get('/search', [RackController::class, 'search']);
        Route::post('/create', [RackController::class, 'create']);
        Route::put('/update/{id}', [RackController::class, 'update']);
        Route::delete('/delete/{id}', [RackController::class, 'destroy']);
    });

    Route::prefix('history')->group(function () {
        Route::get('/data/{params}', [HistoryController::class, 'data']);
        Route::get('/search', [HistoryController::class, 'search']);
        Route::delete('/rollback/{id}', [HistoryController::class, 'rollback']);
        Route::delete('/delete/{params}', [HistoryController::class, 'destroy']);

    });

    Route::prefix('laporan')->group(function () {
        Route::post('/{params}', [LaporanController::class, 'download']);
    });

    Route::prefix('karyawan')->group(function () {
        Route::get('/data', [UserController::class, 'data']);
        Route::get('/search', [UserController::class, 'search']);
        Route::post('/create', [UserController::class, 'create']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('chart')->group(function () {
        Route::get('/bar/{year}/{act}', [HomeController::class, 'dataBarIncomeOutcome']);
        Route::get('/pie/{year}/{act}', [HomeController::class, 'dataPieIncomeOutcome']);
        Route::get('/pie/list', [HomeController::class, 'listMaterial']);
    });

    Route::get('/stock-kosong', [HomeController::class, 'alertStockSpv']);
});