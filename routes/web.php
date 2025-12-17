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
        Route::get('/{id}/download-word', [SKDirekturController::class, 'downloadWord'])->name('download-word');
        Route::get('/{id}/download-rtf', [SKDirekturController::class, 'downloadRTF'])->name('download-rtf');
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
        Route::get('/sk-direktur', [TemplateSuratController::class, 'skDirektur'])->name('sk-direktur.index');
        Route::post('/sk-direktur/store', [TemplateSuratController::class, 'store'])->name('sk-direktur.store');
        Route::get('/sk-direktur/file/{id}', [TemplateSuratController::class, 'file'])->name('sk-direktur.file');
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
