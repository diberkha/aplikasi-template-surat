<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\SOP;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArsipSuratController extends Controller
{
    public function index(Request $request)
    {
        $templateOptions = TemplateSurat::select('id_template_surat', 'nama_template_surat')
            ->orderBy('nama_template_surat')
            ->get();

        $query = Surat::with(['template', 'createdBy', 'skDirektur', 'sop', 'cuti'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_surat', 'LIKE', "%{$search}%")
                    ->orWhere('nomor_surat', 'LIKE', "%{$search}%")
                    ->orWhereHas('template', function ($query) use ($search) {
                        $query->where('nama_template_surat', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('createdBy', function ($query) use ($search) {
                        $query->where('username', 'LIKE', "%{$search}%");
                    });
            });
        }

        if ($request->filled('template')) {
            $query->where('id_template_surat', $request->template);
        }

        if ($request->filled('start_date')) {
            $query->where('tanggal_dibuat', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('tanggal_dibuat', '<=', $request->end_date);
        }

        $surat = $query->get();
        foreach ($surat as $item) {
            \Log::info('Surat:', $item->toArray());
            if ($item->skDirektur) {
                \Log::info('SKDirektur:', $item->skDirektur->toArray());
            } else {
                \Log::info('SKDirektur: null');
            }
        }
        $totalSurat = $surat->count();

        $debugRecent = null;
        if ($request->query('debug') == '1') {
            $debugRecent = Surat::orderBy('created_at', 'desc')->take(5)->get();
        }

        return view('arsip-surat.index', compact('surat', 'totalSurat', 'templateOptions', 'debugRecent'));
    }

    public function show($id)
    {
        $surat = Surat::with('template', 'sop')->findOrFail($id);

        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            abort(404, 'File surat tidak ditemukan.');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf'; // Fallback
        
        if (str_contains($templateName, 'Surat Izin Cuti')) {
            $jenis = 'PNS';
            if (str_contains($templateName, 'PPPK')) $jenis = 'PPPK';
            if (str_contains($templateName, 'Non ASN')) $jenis = 'Non ASN';
            $parts = explode('-', $surat->nomor_surat);
            $nama = $parts[2] ?? 'Dokumen';
            $filename = "Surat Izin Cuti-{$jenis}-{$nama}.pdf";
        } elseif (str_contains($templateName, 'SK Direktur') || $surat->nama_surat === 'Surat Keputusan Direktur') {
            $filename = 'SK Direktur-' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
        } elseif (str_contains($templateName, 'SOP') || $surat->nama_surat === 'Standar Operasional Prosedur (SOP)') {
            $sop = $surat->sop;
            $nomor = ($sop && $sop->nomor_dokumen) ? $sop->nomor_dokumen : $surat->nomor_surat;
            $filename = 'SOP-' . str_replace('/', '-', $nomor) . '.pdf';
        } else {
            $cleanJudul = str_replace(' ', '-', trim($surat->nama_surat ?? $templateName));
            $cleanNomor = str_replace('/', '-', trim($surat->nomor_surat));
            $filename = "{$cleanJudul}-{$cleanNomor}.pdf";
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function download($id)
    {
        $surat = Surat::with('template', 'sop')->findOrFail($id);
        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf'; // Fallback
        
        if (str_contains($templateName, 'Surat Izin Cuti')) {
            $jenis = 'PNS';
            if (str_contains($templateName, 'PPPK')) $jenis = 'PPPK';
            if (str_contains($templateName, 'Non ASN')) $jenis = 'Non ASN';
            
            // Try to get name from nomor_surat if possible, or fallback to full nomor
            // nomor_surat format: CUTI-[KATEGORI]-[NAMA]-[ID]
            $parts = explode('-', $surat->nomor_surat);
            $nama = $parts[2] ?? 'Dokumen';
            $filename = "Surat Izin Cuti-{$jenis}-{$nama}.pdf";
        } elseif (str_contains($templateName, 'SK Direktur') || $surat->nama_surat === 'Surat Keputusan Direktur') {
            $filename = 'SK Direktur-' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
        } elseif (str_contains($templateName, 'SOP') || $surat->nama_surat === 'Standar Operasional Prosedur (SOP)') {
            $sop = $surat->sop;
            $nomor = ($sop && $sop->nomor_dokumen) ? $sop->nomor_dokumen : $surat->nomor_surat;
            $filename = 'SOP-' . str_replace('/', '-', $nomor) . '.pdf';
        } else {
            $cleanJudul = str_replace(' ', '-', trim($surat->nama_surat ?? $templateName));
            $cleanNomor = str_replace('/', '-', trim($surat->nomor_surat));
            $filename = "{$cleanJudul}-{$cleanNomor}.pdf";
        }

        return response()->download($path, $filename);
    }



    public function destroy($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            $path = storage_path('app/' . $surat->file_path);

            if ($surat->file_path && file_exists($path)) {
                unlink($path);
            }

            $surat->delete();

            return redirect()->route('arsip-surat.index')->with('success', 'Surat berhasil dihapus');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('arsip-surat.index')->with('error', 'Surat tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->route('arsip-surat.index')->with('error', 'Terjadi kesalahan saat menghapus surat');
        }
    }
}
