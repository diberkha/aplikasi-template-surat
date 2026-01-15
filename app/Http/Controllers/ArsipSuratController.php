<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\SOP;
use App\Models\SKDirektur;
use App\Models\SuratIzinCuti;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Ruangan;

class ArsipSuratController extends Controller
{
    public function index(Request $request)
    {
        $templateOptions = TemplateSurat::select('id_template_surat', 'nama_template_surat')
            ->orderBy('nama_template_surat')
            ->get();

        $ruanganOptions = [];
        if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha')) {
            $ruanganOptions = Ruangan::where('nama_ruangan', '!=', 'Admin')
                ->orderBy('nama_ruangan')
                ->get();
        }

        $query = Surat::with(['template', 'createdBy', 'skDirektur', 'sop', 'cuti'])
            ->where('is_draft', false)
            ->orderBy('created_at', 'desc');

        $user = auth()->user();

        if ($user->hasRole('Admin') || $user->hasRole('Tata Usaha')) {
            if ($request->has('ruangan_id') && $request->ruangan_id) {
                $roomId = $request->ruangan_id;
                $query->whereHas('createdBy', function ($q) use ($roomId) {
                    $q->where('id_ruangan', $roomId);
                });
            }
        } else {
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

            if (($tipeSurat === 'Standar Operasional Prosedur' || $tipeSurat === 'Standar Operasional Prosedur (SOP)') && $item->sop) {
                $nomorSurat = $item->sop->nomor_dokumen ?? $nomorSurat;
                $tipeSuratDisplay = 'Standar Operasional Prosedur (SOP)';
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
            } elseif ($tipeSuratDisplay === 'Standar Operasional Prosedur (SOP)' || $tipeSuratDisplay === 'Standar Operasional Prosedur') {
                $docxUrl = route('template-surat.sop.docx', $idSurat);
                $tipeSuratDisplay = 'Standar Operasional Prosedur (SOP)';
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
            'ruanganOptions' => $ruanganOptions,
            'debugRecent' => $debugRecent
        ]);
    }

    public function storeImport(Request $request)
    {
        $request->validate([
            'nama_surat' => 'required|string|max:255',
            'tipe_surat' => 'required|string|in:Surat Keputusan Direktur,Standar Operasional Prosedur (SOP),Standar Operasional Prosedur',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_dibuat' => 'required|date',
            'file_surat' => 'required|file|mimes:pdf,docx|max:10240',
        ]);

        try {
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('arsip/import', $filename);

            $tipeSurat = $request->tipe_surat;
            $template = TemplateSurat::where('nama_template_surat', $tipeSurat)
                ->orWhere('nama_template_surat', 'Standar Operasional Prosedur')
                ->orWhere('nama_template_surat', 'Standar Operasional Prosedur (SOP)')
                ->first();
            $idTemplate = $template ? $template->id_template_surat : null;

            Surat::create([
                'nama_surat' => $request->nama_surat,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'file_path' => $path,
                'is_draft' => false,
                'created_by' => auth()->id(),
                'id_template_surat' => $idTemplate,
            ]);

            return redirect()->route('arsip-surat.index')->with('success', 'Surat berhasil diimport');
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengimport surat: ' . $e->getMessage());
        }
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
            if ($surat->is_draft) {
                try {
                    $direktur = Pegawai::getDirektur();
                    $direktur_nama = $direktur ? $direktur->nama : 'Dr. dr. Kinik Darsono, M.Pd.Ked.';
                    $direktur_nip = $direktur ? $direktur->nip : '19710415 200903 1 001';

                    if ($surat->sop) {
                        $data = [
                            'judul_sop' => $surat->sop->judul_sop,
                            'nomor_dokumen' => $surat->sop->nomor_dokumen,
                            'nomor_revisi' => $surat->sop->nomor_revisi,
                            'halaman' => $surat->sop->halaman,
                            'tanggal_terbit' => $surat->sop->tanggal_terbit,
                            'pengertian' => $surat->sop->pengertian,
                            'tujuan' => explode("\n", $surat->sop->tujuan),
                            'kebijakan' => $surat->sop->kebijakan,
                            'prosedur' => explode("\n", $surat->sop->prosedur),
                            'unit_terkait' => $surat->sop->unit_terkait,
                            'direktur_nama' => $direktur_nama,
                            'direktur_nip' => $direktur_nip,
                        ];
                        $pdf = Pdf::loadView('template-surat.sop.pdf', ['data' => $data]);
                        $newPath = 'surat/' . $surat->nomor_surat . '.pdf';
                        Storage::put($newPath, $pdf->output());
                        $surat->update(['file_path' => $newPath]);
                        $path = storage_path('app/' . $newPath);
                    } elseif ($surat->skDirektur) {
                        $data = [
                            'nomor_surat' => $surat->nomor_surat,
                            'tentang' => $surat->skDirektur->tentang,
                            'menimbang' => explode("\n", $surat->skDirektur->menimbang),
                            'mengingat' => $surat->skDirektur->mengingat,
                            'memutuskan' => $surat->skDirektur->memutuskan,
                            'menetapkan' => $surat->skDirektur->menetapkan,
                            'tempat_surat' => $surat->skDirektur->tempat_dibuat,
                            'tanggal_dibuat' => $surat->skDirektur->tanggal_dibuat,
                            'direktur_nama' => $direktur_nama,
                            'direktur_nip' => $direktur_nip,
                        ];
                        $html = view('template-surat.sk-direktur.pdf', ['data' => $data, 'surat' => $surat])->render();
                        $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 612, 936], 'portrait')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'defaultFont' => 'Times New Roman']);
                        $newPath = 'arsip/SK Direktur-' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
                        Storage::put($newPath, $pdf->output());
                        $surat->update(['file_path' => $newPath]);
                        $path = storage_path('app/' . $newPath);
                    } elseif ($surat->cuti) {
                        $data = [
                            'kategori' => $surat->cuti->kategori,
                            'form' => $surat->cuti->form_data,
                            'nomor_surat' => $surat->nomor_surat,
                            'direktur_nama' => $direktur_nama,
                            'direktur_nip' => $direktur_nip,
                        ];
                        $view = 'template-surat.cuti.cuti-pns.pdf';
                        if ($data['kategori'] === 'PPPK')
                            $view = 'template-surat.cuti.cuti-pppk.pdf';
                        if ($data['kategori'] === 'NON ASN')
                            $view = 'template-surat.cuti.cuti-nonasn.pdf';

                        $html = view($view, ['data' => $data, 'surat' => $surat])->render();
                        $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 612, 936], 'portrait')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'defaultFont' => 'Times New Roman']);
                        $newPath = 'arsip/' . $surat->nomor_surat . '.pdf';
                        Storage::put($newPath, $pdf->output());
                        $surat->update(['file_path' => $newPath]);
                        $path = storage_path('app/' . $newPath);
                    }
                } catch (\Exception $e) {
                    Log::error('Regeneration failed: ' . $e->getMessage());
                }
            }

            if (!file_exists($path)) {
                abort(404, 'File surat tidak ditemukan di server.');
            }
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

            if ($surat->file_path && $surat->file_path != '#' && file_exists($path)) {
                unlink($path);
            }

            $surat->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Draft/Surat berhasil dihapus'
                ]);
            }

            return redirect()->route('arsip-surat.index')->with('success', 'Surat berhasil dihapus');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Surat tidak ditemukan'], 404);
            }
            return redirect()->route('arsip-surat.index')->with('error', 'Surat tidak ditemukan');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus: ' . $e->getMessage()], 500);
            }
            return redirect()->route('arsip-surat.index')->with('error', 'Terjadi kesalahan saat menghapus surat');
        }
    }
}
