<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DraftSuratController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\SKDirekturController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TemplateSuratController;
use App\Http\Controllers\RegulasiController;
use App\Http\Controllers\SOPController;
use App\Http\Controllers\IzinCutiController;
use App\Http\Controllers\IzinCutiPNSController;
use App\Http\Controllers\IzinCutiPPPKController;
use App\Http\Controllers\IzinCutiNonAsnController;
use App\Http\Controllers\SKDirekturDocxController;
use App\Http\Controllers\SOPDocxController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\CutiBersamaController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('arsip-surat')->name('arsip-surat.')->group(function () {
        Route::get('/', [ArsipSuratController::class, 'index'])->name('index');
        Route::get('/{id}', [ArsipSuratController::class, 'show'])->name('show');
        Route::get('/{id}/download', [ArsipSuratController::class, 'download'])->name('download');
        Route::post('/import', [ArsipSuratController::class, 'storeImport'])->name('import');
        Route::delete('/{id}', [ArsipSuratController::class, 'destroy'])->middleware('role:Admin,Tata Usaha')->name('destroy');
    });

    Route::prefix('draft-surat')->name('draft-surat.')->group(function () {
        Route::get('/sop', [DraftSuratController::class, 'sopIndex'])->name('sop.index');
        Route::get('/sk-direktur', [DraftSuratController::class, 'skDirekturIndex'])->name('sk-direktur.index');
        Route::get('/cuti', [DraftSuratController::class, 'cutiIndex'])->name('cuti.index');
    });

    Route::post('/sop/{id}/archive', [SOPController::class, 'archive'])->name('sop.archive');
    Route::get('/sop/{id}/edit', [SOPController::class, 'edit'])->name('sop.edit');
    Route::put('/sop/{id}', [SOPController::class, 'update'])->name('sop.update');

    Route::post('/sk-direktur/{id}/archive', [SKDirekturController::class, 'archive'])->name('sk-direktur.archive');
    Route::get('/sk-direktur/{id}/edit', [SKDirekturController::class, 'edit'])->name('sk-direktur.edit');
    Route::put('/sk-direktur/{id}', [SKDirekturController::class, 'update'])->name('sk-direktur.update');

    Route::post('/cuti/{id}/archive', [IzinCutiController::class, 'archive'])->name('cuti.archive');
    Route::get('/cuti/{id}/edit', [IzinCutiController::class, 'edit'])->name('cuti.edit');
    Route::put('/cuti/{id}', [IzinCutiController::class, 'update'])->name('cuti.update');

    Route::prefix('master-data')->group(function () {
        Route::prefix('ruangan')->group(function () {
            Route::get('/', [RuanganController::class, 'index'])->name('master-data.ruangan.index');
            Route::post('/', [RuanganController::class, 'store'])->name('master-data.ruangan.store');
            Route::put('/{ruangan}', [RuanganController::class, 'update'])->name('master-data.ruangan.update');
            Route::delete('/{ruangan}', [RuanganController::class, 'destroy'])->name('master-data.ruangan.destroy');
        });

        Route::prefix('unit')->middleware('role:Admin')->group(function () {
            Route::get('/', [UnitController::class, 'index'])->name('master-data.unit.index');
            Route::post('/', [UnitController::class, 'store'])->name('master-data.unit.store');
            Route::put('/{unit}', [UnitController::class, 'update'])->name('master-data.unit.update');
            Route::delete('/{unit}', [UnitController::class, 'destroy'])->name('master-data.unit.destroy');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('master-data.user.index');
            Route::post('/', [UserController::class, 'store'])->name('master-data.user.store');
            Route::put('/{user}', [UserController::class, 'update'])->name('master-data.user.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('master-data.user.destroy');
        });

        Route::prefix('jabatan')->middleware('role:Admin')->group(function () {
            Route::get('/', [JabatanController::class, 'index'])->name('master-data.jabatan.index');
            Route::post('/', [JabatanController::class, 'store'])->name('master-data.jabatan.store');
            Route::put('/{jabatan}', [JabatanController::class, 'update'])->name('master-data.jabatan.update');
            Route::delete('/{jabatan}', [JabatanController::class, 'destroy'])->name('master-data.jabatan.destroy');
        });

        Route::prefix('regulasi')->name('master-data.regulasi.')->middleware('role:Admin,Tata Usaha')->controller(RegulasiController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        Route::prefix('pegawai')->name('master-data.pegawai.')->middleware('role:Admin,Tata Usaha')->controller(\App\Http\Controllers\PegawaiController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        Route::prefix('cuti-bersama')->name('cuti-bersama.')->middleware('role:Admin,Tata Usaha')->group(function () {
            Route::get('/', [CutiBersamaController::class, 'index'])->name('index');
            Route::get('/create', [CutiBersamaController::class, 'create'])->name('create');
            Route::post('/', [CutiBersamaController::class, 'store'])->name('store');
            Route::get('/{cutiBersama}/edit', [CutiBersamaController::class, 'edit'])->name('edit');
            Route::put('/{cutiBersama}', [CutiBersamaController::class, 'update'])->name('update');
            Route::delete('/{cutiBersama}', [CutiBersamaController::class, 'destroy'])->name('destroy');
        });
    });


    Route::prefix('template-surat')->name('template-surat.')->group(function () {
        Route::middleware('role:Admin,Tata Usaha')->group(function () {
            Route::get('/sk-direktur', [SKDirekturController::class, 'index'])->name('sk-direktur.index');
            Route::post('/sk-direktur/store', [SKDirekturController::class, 'store'])->name('sk-direktur.store');
            Route::get('/sk-direktur/file/{id}', [SKDirekturController::class, 'file'])->name('sk-direktur.file');
            Route::delete('/sk-direktur/{template_surat}', [SKDirekturController::class, 'destroy'])->whereNumber('template_surat')->name('sk-direktur.destroy');
        });

        Route::get('/sop', [SOPController::class, 'index'])->name('sop.index');
        Route::post('/sop/store', [SOPController::class, 'store'])->name('sop.store');
        Route::get('/sop/file/{id}', [SOPController::class, 'file'])->name('sop.file');
        Route::delete('/sop/{template_surat}', [SOPController::class, 'destroy'])
            ->middleware('role:Admin')
            ->whereNumber('template_surat')
            ->name('sop.destroy');

        Route::get('/cuti', [IzinCutiController::class, 'index'])->name('cuti.index');
        Route::post('/cuti/store', [IzinCutiController::class, 'store'])->name('cuti.store');
        Route::delete('/cuti/{template_surat}', [IzinCutiController::class, 'destroy'])->whereNumber('template_surat')->name('cuti.destroy');
        Route::get('/cuti/pdf/{id}', [TemplateSuratController::class, 'file'])->name('cuti.file');

        Route::get('/cuti/pns/docx/{id}', [IzinCutiPNSController::class, 'download'])->name('cuti.pns.docx');
        Route::get('/cuti/pppk/docx/{id}', [IzinCutiPPPKController::class, 'download'])->name('cuti.pppk.docx');
        Route::get('/cuti/nonasn/docx/{id}', [IzinCutiNonAsnController::class, 'download'])->name('cuti.nonasn.docx');

        Route::get('/sk-direktur/docx/{id}', [SKDirekturDocxController::class, 'download'])->name('sk-direktur.docx');
        Route::get('/sop/docx/{id}', [SOPDocxController::class, 'download'])->name('sop.docx');
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
