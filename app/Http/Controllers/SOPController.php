<?php

namespace App\Http\Controllers;

use App\Models\SOP;
use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\Regulasi;
use App\Models\Pegawai;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SOPController extends Controller
{
    public function index(Request $request)
    {
        $templates = TemplateSurat::where('nama_template_surat', 'Standar Operasional Prosedur')
            ->orWhere('nama_template_surat', 'like', '%SOP%')
            ->orderBy('nama_template_surat', 'asc')
            ->get()
            ->map(function ($t) {
                return [
                    'id_template_surat' => $t->id_template_surat,
                    'nama_template_surat' => $t->nama_template_surat,
                    'description' => 'Template Standar Operasional Prosedur',
                    'icon' => 'file-alt',
                    'iconColor' => 'blue',
                    'iconBgColor' => 'blue-100',
                    'iconDarkBgColor' => 'green-900',
                    'iconTextColor' => 'green-600',
                    'iconDarkTextColor' => 'green-400',
                    'created_at' => $t->created_at->toISOString(),
                    'updated_at' => $t->updated_at ? $t->updated_at->format('d/m/Y') : '-'
                ];
            });

        return view('template-surat.sop.index', compact('templates'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul_sop' => 'required|string',
                'nomor_dokumen' => 'required|string',
                'nomor_revisi' => 'nullable|string',
                'halaman' => 'nullable|string',
                'tanggal_terbit' => 'required|date',
                'pengertian' => 'required|string',
                'tujuan' => 'required|array|min:1',
                'tujuan.*' => 'required|string',
                'kebijakan' => 'required|array|min:1',
                'prosedur' => 'required|array|min:1',
                'prosedur.*' => 'required|string',
                'unit_terkait' => 'required|array|min:1',
                'template_id' => 'required|exists:template_surat,id_template_surat',
            ]);

            $surat = Surat::create([
                'nama_surat' => 'Standar Operasional Prosedur',
                'nomor_surat' => 'SOP-' . uniqid(),
                'tanggal_dibuat' => $request->tanggal_terbit,
                'id_template_surat' => $request->template_id,
                'id_regulasi' => null,
                'created_by' => auth()->id(),
            ]);

            $kebijakanIds = $request->kebijakan;
            $kebijakanText = '';
            foreach ($kebijakanIds as $index => $id) {
                $kebijakanText .= ($index + 1) . ". " . trim($id) . "\n";
            }

            $unitIds = $request->unit_terkait;
            $unitText = implode(', ', array_map('trim', $unitIds));
            $tujuanText = implode("\n", array_filter($request->tujuan));
            $prosedurText = implode("\n", array_filter($request->prosedur));

            SOP::create([
                'id_surat' => $surat->id_surat,
                'judul_sop' => $request->judul_sop,
                'nomor_dokumen' => $request->nomor_dokumen,
                'nomor_revisi' => $request->nomor_revisi,
                'halaman' => $request->filled('halaman') ? $request->halaman : '1/1',
                'tanggal_terbit' => $request->tanggal_terbit,
                'pengertian' => $request->pengertian,
                'tujuan' => $tujuanText,
                'kebijakan' => trim($kebijakanText),
                'prosedur' => $prosedurText,
                'unit_terkait' => trim($unitText),
            ]);

            $pdfData = $request->all();
            $pdfData['halaman'] = $request->filled('halaman') ? $request->halaman : '1/1';
            $pdfData['tujuan'] = array_filter($request->tujuan);
            $pdfData['kebijakan'] = trim($kebijakanText);
            $pdfData['unit_terkait'] = trim($unitText);

            $direktur = Pegawai::getDirektur();
            $pdfData['direktur_nama'] = $direktur ? $direktur->nama : 'Dr. dr. Kinik Darsono, M.Pd.Ked.';
            $pdfData['direktur_nip'] = $direktur ? $direktur->nip : '19710415 200903 1 001';

            $this->generateAndSavePDF($surat, $pdfData);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Standar Operasional Prosedur berhasil dibuat',
                    'surat_id' => $surat->id_surat,
                    'nomor_surat' => $request->nomor_dokumen,
                    'tanggal_dibuat' => \Carbon\Carbon::parse($surat->tanggal_dibuat)->format('Y-m-d'),
                    'judul_sop' => $request->judul_sop,
                    'file_url' => route('template-surat.sop.file', $surat->id_surat),
                ]);
            }

return redirect()->route('draft-surat.sop.index')->with('success', 'Draft Standar Operasional Prosedur berhasil dibuat');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function archive($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            $surat->update(['is_draft' => false]);

            return response()->json([
                'success' => true,
                'message' => 'Surat berhasil diarsipkan'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mempublikasikan surat: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $surat = Surat::with('sop')->findOrFail($id);

        if ($surat->sop) {
            $surat->sop->tujuan_array = explode("\n", $surat->sop->tujuan);
            $surat->sop->prosedur_array = explode("\n", $surat->sop->prosedur);

            $surat->sop->kebijakan_array = array_map(function ($line) {
                return preg_replace('/^\d+\.\s*/', '', trim($line));
            }, explode("\n", trim($surat->sop->kebijakan)));

            $surat->sop->unit_terkait_array = array_map(function ($line) {
                return preg_replace('/^\d+\.\s*/', '', trim($line));
            }, explode("\n", trim($surat->sop->unit_terkait)));
        }

        return response()->json([
            'success' => true,
            'data' => $surat
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul_sop' => 'required|string',
                'nomor_dokumen' => 'required|string',
                'nomor_revisi' => 'nullable|string',
                'halaman' => 'nullable|string',
                'tanggal_terbit' => 'required|date',
                'pengertian' => 'required|string',
                'tujuan' => 'required|array|min:1',
                'tujuan.*' => 'required|string',
                'kebijakan' => 'required|array|min:1',
                'prosedur' => 'required|array|min:1',
                'prosedur.*' => 'required|string',
                'unit_terkait' => 'required|array|min:1',
            ]);

            $surat = Surat::findOrFail($id);
            $surat->update([
                'tanggal_dibuat' => $request->tanggal_terbit,
            ]);

            $kebijakanText = '';
            foreach ($request->kebijakan as $index => $val) {
                $kebijakanText .= ($index + 1) . ". " . trim($val) . "\n";
            }

            $unitText = implode(', ', array_map('trim', $request->unit_terkait));
            $tujuanText = implode("\n", array_filter($request->tujuan));
            $prosedurText = implode("\n", array_filter($request->prosedur));

            $sop = SOP::where('id_surat', $id)->firstOrFail();
            $sop->update([
                'judul_sop' => $request->judul_sop,
                'nomor_dokumen' => $request->nomor_dokumen,
                'nomor_revisi' => $request->nomor_revisi,
                'halaman' => $request->filled('halaman') ? $request->halaman : '1/1',
                'tanggal_terbit' => $request->tanggal_terbit,
                'pengertian' => $request->pengertian,
                'tujuan' => $tujuanText,
                'kebijakan' => trim($kebijakanText),
                'prosedur' => $prosedurText,
                'unit_terkait' => trim($unitText),
            ]);

            $pdfData = $request->all();
            $pdfData['halaman'] = $request->filled('halaman') ? $request->halaman : '1/1';
            $pdfData['tujuan'] = array_filter($request->tujuan);
            $pdfData['kebijakan'] = trim($kebijakanText);
            $pdfData['unit_terkait'] = trim($unitText);

            $direktur = Pegawai::getDirektur();
            $pdfData['direktur_nama'] = $direktur ? $direktur->nama : 'Dr. dr. Kinik Darsono, M.Pd.Ked.';
            $pdfData['direktur_nip'] = $direktur ? $direktur->nip : '19710415 200903 1 001';

            if ($surat->file_path && Storage::exists($surat->file_path)) {
                Storage::delete($surat->file_path);
            }

            $this->generateAndSavePDF($surat, $pdfData);

            $surat->refresh();
            $surat->load('createdBy.ruangan');

            return response()->json([
                'success' => true,
                'message' => 'Draft SOP berhasil diperbarui',
                'data' => [
                    'id_surat' => $surat->id_surat,
                    'nama_surat' => $surat->nama_surat,
                    'nomor_surat' => $surat->nomor_surat,
                    'created_at' => $surat->created_at->toISOString(),
                    'ruangan' => $surat->createdBy->ruangan->nama_ruangan ?? '-',
                    'tipe_surat' => 'Standar Operasional Prosedur (SOP)'
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui draft: ' . $e->getMessage()
            ], 500);
        }
    }
    private function generateAndSavePDF($surat, $data)
    {
        $pdf = Pdf::loadView('template-surat.sop.pdf', ['data' => $data]);

        $filename = $surat->nomor_surat . '.pdf';
        $path = 'surat/' . $filename;

        Storage::put($path, $pdf->output());

        $surat->update(['file_path' => $path]);

        return $path;
    }
    public function file($id)
    {
        $surat = Surat::with('sop')->findOrFail($id);
        $path = storage_path('app/' . $surat->file_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        $sop = $surat->sop;
        $nomor = ($sop && $sop->nomor_dokumen) ? $sop->nomor_dokumen : $surat->nomor_surat;
        $safeNomor = str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $nomor);
        $filename = 'SOP-' . $safeNomor . '.pdf';

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
