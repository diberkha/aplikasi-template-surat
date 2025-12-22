<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\SKDirekturController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\TemplateSuratController;
use App\Http\Controllers\RegulasiController;
use App\Http\Controllers\SOPController;
use App\Http\Controllers\CutiController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('arsip-surat')->name('arsip-surat.')->group(function () {
        Route::get('/', [ArsipSuratController::class, 'index'])->name('index');
        Route::get('/{id}', [ArsipSuratController::class, 'show'])->name('show');
        Route::get('/{id}/download', [ArsipSuratController::class, 'download'])->name('download');
        Route::delete('/{id}', [ArsipSuratController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('master-data')->group(function () {
        Route::prefix('ruangan')->group(function () {
            Route::get('/', [RuanganController::class, 'index'])->name('master-data.ruangan.index');
            Route::post('/', [RuanganController::class, 'store'])->name('master-data.ruangan.store');
            Route::put('/{ruangan}', [RuanganController::class, 'update'])->name('master-data.ruangan.update');
            Route::delete('/{ruangan}', [RuanganController::class, 'destroy'])->name('master-data.ruangan.destroy');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('master-data.user.index');
            Route::post('/', [UserController::class, 'store'])->name('master-data.user.store');
            Route::put('/{user}', [UserController::class, 'update'])->name('master-data.user.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('master-data.user.destroy');
        });

        Route::prefix('regulasi')->name('master-data.regulasi.')->controller(RegulasiController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/get-surat/{templateId}', 'getSuratByTemplate')->name('get.surat');
            Route::get('/detail/{id}', 'getRegulasiDetail')->name('detail');
            Route::get('/edit-data/{id}', 'getRegulasiForEdit')->name('edit.data');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });

    Route::prefix('api/regulasi')->group(function () {
        Route::get('/', [RegulasiController::class, 'getRegulasiList']);
        Route::get('/{id}/data', [RegulasiController::class, 'getRegulasiData']);
    });

    Route::prefix('template-surat')->name('template-surat.')->group(function () {
        Route::get('/sk-direktur', [SKDirekturController::class, 'index'])->name('sk-direktur.index');
        Route::post('/sk-direktur/store', [SKDirekturController::class, 'store'])->name('sk-direktur.store');
        Route::get('/sk-direktur/file/{id}', [SKDirekturController::class, 'file'])->name('sk-direktur.file');
        Route::delete('/sk-direktur/{template_surat}', [SKDirekturController::class, 'destroy'])->whereNumber('template_surat')->name('sk-direktur.destroy');
        Route::get('/sop', [SOPController::class, 'index'])->name('sop.index');
        Route::post('/sop/store', [SOPController::class, 'store'])->name('sop.store');
        Route::delete('/sop/{template_surat}', [SOPController::class, 'destroy'])->whereNumber('template_surat')->name('sop.destroy');
        Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
        Route::post('/cuti/store', [CutiController::class, 'store'])->name('cuti.store');
        Route::get('/cuti/pdf/{id}', [TemplateSuratController::class, 'file'])->name('cuti.file');
    });


    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

Route::get('/home', function () {
    return redirect('/dashboard');
});
