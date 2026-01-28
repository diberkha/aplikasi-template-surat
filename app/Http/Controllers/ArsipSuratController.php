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
    use \App\Traits\LazyPdfTrait;
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

        $query = Surat::with(['template', 'createdBy', 'skDirektur', 'sop.contents', 'cuti'])
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
            $query->where('created_by', $user->id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('tanggal_dibuat', '>=', $request->start_date)
                ->whereDate('tanggal_dibuat', '<=', $request->end_date);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('tanggal_dibuat', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('tanggal_dibuat', $request->end_date);
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
                $firstPage = $item->sop->contents->first();
                $nomorSurat = ($firstPage && $firstPage->nomor_dokumen) ? $firstPage->nomor_dokumen : ($item->sop->nomor_dokumen ?: $nomorSurat);
                $tipeSuratDisplay = 'Standar Operasional Prosedur (SOP)';
                $namaSuratDisplay = ($firstPage && $firstPage->judul_sop) ? $firstPage->judul_sop : ($item->sop->judul_sop ?: $namaSurat);
            }

            if (($tipeSurat === 'Surat Keputusan Direktur' || $tipeSurat === 'SK Direktur' || $item->nama_surat === 'Surat Keputusan Direktur')) {
                $tipeSuratDisplay = 'Surat Keputusan Direktur';
                if ($item->skDirektur && $item->skDirektur->tentang) {
                    $words = explode(' ', $item->skDirektur->tentang);
                    $namaSuratDisplay = implode(' ', array_slice($words, 0, 5));
                }
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

                $formData = $item->cuti->form_data;
                $nama = isset($formData['nama']) ? $formData['nama'] : 'Pegawai';
                $nomorSurat = $nama;

                if (isset($formData['nama'])) {
                    $namaSuratDisplay = $formData['nama'];
                } else {
                    $namaSuratDisplay = $namaSurat;
                }
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
                'tanggal_dibuat' => $item->tanggal_dibuat ? $item->tanggal_dibuat->toDateString() : null,
                'created_at' => $item->created_at->toDateTimeString(),
                'username' => $item->createdBy->username ?? 'Unknown',
                'ruangan' => $item->createdBy->ruangan->nama_ruangan ?? '-',
                'id_ruangan' => $item->createdBy->id_ruangan ?? null,
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

        $pegawais = Pegawai::orderBy('nama', 'asc')->get();

        return view('arsip-surat.index', [
            'surat' => $suratData,
            'totalSurat' => $totalSurat,
            'templateOptions' => $templateOptions,
            'ruanganOptions' => $ruanganOptions,
            'debugRecent' => $debugRecent,
            'pegawais' => $pegawais
        ]);
    }

    public function storeImport(Request $request)
    {
        $request->validate([
            'tipe_surat' => 'required|string',
            'tanggal_dibuat' => 'required|date',
            'file_surat' => 'required|file|mimes:pdf|max:10240',
            'nama_surat' => 'required_unless:tipe_surat,Surat Izin Cuti|nullable|string|max:255',
            'nomor_surat' => 'required_unless:tipe_surat,Surat Izin Cuti|nullable|string|max:255',
            'kategori_pegawai' => 'required_if:tipe_surat,Surat Izin Cuti|nullable|string|in:PNS,PPPK,NON ASN',
            'pegawai_nama' => 'required_if:tipe_surat,Surat Izin Cuti|nullable|string|max:255',
        ]);

        try {
            $file = $request->file('file_surat');
            $tipe = $request->tipe_surat;
            $namaSurat = $request->nama_surat;
            $nomorSurat = $request->nomor_surat;

            if ($tipe === 'Surat Izin Cuti') {
                $namaSurat = $request->pegawai_nama;
                $kategori = strtoupper($request->kategori_pegawai ?? 'IMPORT');
                $namaClean = strtoupper(trim($request->pegawai_nama));
                $nomorSurat = "CUTI-{$kategori}-{$namaClean}";
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('arsip/import', $filename);

            $template = TemplateSurat::where('nama_template_surat', $tipe)
                ->orWhere('nama_template_surat', 'like', '%' . $tipe . '%')
                ->first();
            $idTemplate = $template ? $template->id_template_surat : null;

            $surat = Surat::create([
                'nama_surat' => $namaSurat,
                'nomor_surat' => $nomorSurat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'file_path' => $path,
                'is_draft' => false,
                'created_by' => auth()->id(),
                'id_template_surat' => $idTemplate,
            ]);

            if ($tipe === 'Standar Operasional Prosedur (SOP)' || $tipe === 'Standar Operasional Prosedur') {
                SOP::create([
                    'id_surat' => $surat->id_surat,
                    'nomor_dokumen' => $nomorSurat,
                    'judul_sop' => $namaSurat,
                    'tanggal_terbit' => $request->tanggal_dibuat,
                    'nomor_revisi' => '0',
                    'halaman' => '1/1',
                    'pengertian' => 'Imported',
                    'tujuan' => 'Imported',
                    'kebijakan' => 'Imported',
                    'prosedur' => 'Imported',
                    'unit_terkait' => 'Imported',
                ]);
            } elseif ($tipe === 'Surat Keputusan Direktur') {
                SKDirektur::create([
                    'id_surat' => $surat->id_surat,
                    'nomor_surat' => $nomorSurat,
                    'judul_surat' => $namaSurat,
                    'tentang' => $namaSurat,
                    'tanggal_dibuat' => $request->tanggal_dibuat,
                    'menimbang' => 'Imported',
                    'mengingat' => 'Imported',
                    'menetapkan' => 'Imported',
                    'memutuskan' => 'Imported',
                    'tempat_dibuat' => 'Gemolong',
                ]);
            } elseif ($tipe === 'Surat Izin Cuti') {
                SuratIzinCuti::create([
                    'id_surat' => $surat->id_surat,
                    'kategori' => $request->kategori_pegawai,
                    'form_data' => [
                        'nama' => $request->pegawai_nama,
                        'is_import' => true
                    ]
                ]);
            }

            return redirect()->route('arsip-surat.index')->with('success', 'Surat berhasil diimport');
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengimport surat: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $surat = Surat::with(['template', 'sop', 'skDirektur', 'cuti', 'createdBy'])->findOrFail($id);

        if (!auth()->user()->hasRole(['Admin', 'Tata Usaha'])) {
            if ($surat->created_by && $surat->createdBy->id_ruangan != auth()->user()->id_ruangan) {
                abort(403, 'Unauthorized');
            }
        }

        $path = $this->ensurePdfExists($surat);

        if (!file_exists($path)) {
            abort(404, 'File surat tidak ditemukan di server.');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf';

        if (str_contains($templateName, 'Surat Izin Cuti')) {
            $filename = str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';
        } elseif (str_contains($templateName, 'SK Direktur') || $surat->nama_surat === 'Surat Keputusan Direktur') {
            $filename = 'SK Direktur-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';
        } elseif (str_contains($templateName, 'SOP') || $surat->nama_surat === 'Standar Operasional Prosedur (SOP)') {
            $sop = $surat->sop;
            $nomor = ($sop && $sop->nomor_dokumen) ? $sop->nomor_dokumen : $surat->nomor_surat;
            $filename = 'SOP-' . str_replace(['/', '\\'], '-', $nomor) . '.pdf';
        } else {
            $cleanJudul = str_replace(' ', '-', trim($surat->nama_surat ?? $templateName));
            $cleanNomor = str_replace(['/', '\\'], '-', $surat->nomor_surat);
            $filename = "{$cleanJudul}-{$cleanNomor}.pdf";
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $mimeType = 'application/pdf';
        if ($extension === 'docx') {
            $mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        } elseif ($extension === 'doc') {
            $mimeType = 'application/msword';
        }

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function download($id)
    {
        $surat = Surat::with(['template', 'sop', 'skDirektur', 'cuti', 'createdBy'])->findOrFail($id);

        if (!auth()->user()->hasRole(['Admin', 'Tata Usaha'])) {
            if ($surat->created_by && $surat->createdBy->id_ruangan != auth()->user()->id_ruangan) {
                abort(403, 'Unauthorized');
            }
        }

        $path = $this->ensurePdfExists($surat);

        if (!file_exists($path)) {
            return back()->with('error', 'File surat tidak ditemukan');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        if (str_contains($templateName, 'Surat Izin Cuti')) {
            $filename = str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';
        } elseif (str_contains($templateName, 'SK Direktur') || $surat->nama_surat === 'Surat Keputusan Direktur') {
            $filename = 'SK Direktur-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';
        } elseif (str_contains($templateName, 'SOP') || $surat->nama_surat === 'Standar Operasional Prosedur (SOP)') {
            $sop = $surat->sop;
            $nomor = ($sop && $sop->nomor_dokumen) ? $sop->nomor_dokumen : $surat->nomor_surat;
            $filename = 'SOP-' . str_replace(['/', '\\'], '-', $nomor) . '.pdf';
        } else {
            $cleanJudul = str_replace(' ', '-', trim($surat->nama_surat ?? $templateName));
            $cleanNomor = str_replace(['/', '\\'], '-', $surat->nomor_surat);
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
