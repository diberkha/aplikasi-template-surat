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

        $user = auth()->user();
        if (!$user->hasRole('Admin')) {
            $roomId = $user->id_ruangan;
            $query->whereHas('createdBy', function ($q) use ($roomId) {
                $q->where('id_ruangan', $roomId);
            });
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tanggal_dibuat', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tanggal_dibuat', '<=', $request->end_date);
        }

        $suratData = $query->get()->map(function ($item) {
            $idSurat = $item->id_surat;
            $namaSurat = $item->nama_surat;
            $nomorSurat = $item->nomor_surat;
            $tipeSurat = $item->tipe_surat;
            $tipeSuratDisplay = $tipeSurat;
            $namaSuratDisplay = $namaSurat;
            $kategoriLabel = '';

            if ($tipeSurat === 'Standar Operasional Prosedur (SOP)' && $item->sop) {
                $nomorSurat = $item->sop->nomor_dokumen ?? $nomorSurat;
            }

            if (strpos($tipeSurat, 'Surat Izin Cuti') !== false && $item->cuti) {
                $kategori = strtoupper($item->cuti->kategori ?? '');
                $kategoriLabel = trim($kategori);
                if (!$kategoriLabel) {
                    $kategoriLabel = trim(str_ireplace('Surat Izin Cuti', '', $tipeSurat));
                }
                if (strtoupper($kategoriLabel) === 'NON ASN') {
                    $kategoriLabel = 'Non ASN';
                }
                $tipeSuratDisplay = 'Surat Izin Cuti';
                $namaSuratDisplay = trim('Surat Izin Cuti ' . $kategoriLabel);
            }

            $docxUrl = '#';
            if ($tipeSuratDisplay === 'Surat Izin Cuti' && $kategoriLabel) {
                $kat = strtoupper($kategoriLabel);
                if ($kat === 'PNS')
                    $docxUrl = route('template-surat.cuti.pns.docx', $idSurat);
                elseif ($kat === 'PPPK')
                    $docxUrl = route('template-surat.cuti.pppk.docx', $idSurat);
                elseif ($kat === 'NON ASN')
                    $docxUrl = route('template-surat.cuti.nonasn.docx', $idSurat);
            } elseif ($tipeSuratDisplay === 'Surat Keputusan Direktur') {
                $docxUrl = route('template-surat.sk-direktur.docx', $idSurat);
            } elseif ($tipeSuratDisplay === 'Standar Operasional Prosedur (SOP)') {
                $docxUrl = route('template-surat.sop.docx', $idSurat);
            }

            $badgeColor = [
                'Surat Keputusan Direktur' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                'Standar Operasional Prosedur (SOP)' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                'Surat Izin Cuti' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            ][$tipeSuratDisplay] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';

            return [
                'id_surat' => $idSurat,
                'nama_surat' => $namaSurat,
                'nomor_surat' => $nomorSurat,
                'tipe_surat' => $tipeSurat,
                'tipe_surat_display' => $tipeSuratDisplay,
                'nama_surat_display' => $namaSuratDisplay,
                'tanggal_dibuat' => $item->tanggal_dibuat,
                'created_at' => $item->created_at->toDateTimeString(),
                'username' => $item->createdBy->username ?? 'Unknown',
                'ruangan' => $item->createdBy->ruangan->nama_ruangan ?? '-',
                'docx_url' => $docxUrl,
                'show_url' => route('arsip-surat.show', $idSurat),
                'download_url' => route('arsip-surat.download', $idSurat),
                'badge_color' => $badgeColor,
                'id_template_surat' => $item->id_template_surat,
                'file_path' => $item->file_path
            ];
        });

        $totalSurat = $suratData->count();

        $debugRecent = null;
        if ($request->query('debug') == '1') {
            $debugRecent = Surat::orderBy('created_at', 'desc')->take(5)->get();
        }

        return view('arsip-surat.index', [
            'surat' => $suratData,
            'totalSurat' => $totalSurat,
            'templateOptions' => $templateOptions,
            'debugRecent' => $debugRecent
        ]);
    }

    public function show($id)
    {
        $surat = Surat::with('template', 'sop')->findOrFail($id);

        if (!auth()->user()->hasRole('Admin')) {
            if ($surat->created_by && $surat->createdBy->id_ruangan != auth()->user()->id_ruangan) {
                abort(403, 'Unauthorized');
            }
        }

        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            abort(404, 'File surat tidak ditemukan');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf';

        if (str_contains($templateName, 'Surat Izin Cuti')) {
            $filename = "{$surat->nomor_surat}.pdf";
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

        if (!auth()->user()->hasRole('Admin')) {
            if ($surat->created_by && $surat->createdBy->id_ruangan != auth()->user()->id_ruangan) {
                abort(403, 'Unauthorized');
            }
        }

        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            return back()->with('error', 'File surat tidak ditemukan');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf';
        if (str_contains($templateName, 'Surat Izin Cuti')) {
            $filename = "{$surat->nomor_surat}.pdf";
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
