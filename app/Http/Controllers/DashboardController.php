<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $templateQuery = TemplateSurat::query();
        if (!$user->hasRole(['Admin', 'Tata Usaha'])) {
            $templateQuery->where(function ($q) {
                $q->where('nama_template_surat', 'LIKE', '%Cuti%')
                    ->orWhere('nama_template_surat', 'LIKE', '%SOP%');
            });
        }
        $totalTemplate = $templateQuery->count();

        $suratQuery = Surat::where('is_draft', false);
        if (!$user->hasRole('Admin')) {
            $suratQuery->whereHas('createdBy', function ($q) use ($user) {
                $q->where('id_ruangan', $user->id_ruangan);
            });
        }

        $totalSurat = (clone $suratQuery)->count();
        $suratHariIni = (clone $suratQuery)->whereDate('tanggal_dibuat', now())->count();
        $suratBulanIni = (clone $suratQuery)->whereMonth('tanggal_dibuat', now()->month)
            ->whereYear('tanggal_dibuat', now()->year)
            ->count();

        return view('dashboard', compact(
            'totalSurat',
            'totalTemplate',
            'suratHariIni',
            'suratBulanIni'
        ));
    }
}
