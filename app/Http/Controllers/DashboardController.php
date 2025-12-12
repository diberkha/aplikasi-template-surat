<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSurat = Surat::count();
        $totalTemplate = TemplateSurat::count();
        $suratHariIni = Surat::whereDate('tanggal_dibuat', now())->count();
        $suratTersimpan = Surat::whereNotNull('file_path')->count();

        return view('dashboard', compact(
            'totalSurat',
            'totalTemplate',
            'suratHariIni',
            'suratTersimpan'
        ));
    }
}
