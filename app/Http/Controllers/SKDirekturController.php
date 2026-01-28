<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\SKDirektur;
use App\Models\Regulasi;
use App\Models\Pegawai;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class SKDirekturController extends Controller
{
    use \App\Traits\LazyPdfTrait;
    public function index(Request $request)
    {
        $templates = TemplateSurat::where('nama_template_surat', 'Surat Keputusan Direktur')
            ->orderBy('nama_template_surat', 'asc')
            ->get()
            ->map(function ($t) {
                return [
                    'id_template_surat' => $t->id_template_surat,
                    'nama_template_surat' => $t->nama_template_surat,
                    'description' => 'Template Surat Keputusan Direktur',
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

        $regulasis = Regulasi::all();
        return view('template-surat.sk-direktur.index', compact('templates', 'regulasis'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('store request received', ['data' => $request->all()]);

            $request->validate([
                'nomor_surat' => [
                    'required',
                    Rule::unique('surat', 'nomor_surat')->where(function ($query) use ($request) {
                        return $query->where('id_template_surat', $request->template_id);
                    })
                ],
                'tentang' => 'required',
                'menimbang' => 'required|array|min:1',
                'menimbang.*' => 'required|string',
                'mengingat' => 'required|array|min:1',
                'mengingat.*' => 'required|string',
                'menetapkan' => 'nullable|string',
                'memutuskan' => 'nullable|array',
                'memutuskan.0' => 'nullable|string',
                'memutuskan.*' => 'nullable|string',
                'tempat_dibuat' => 'required',
                'tanggal_dibuat' => 'required|date',
                'template_id' => 'required|exists:template_surat,id_template_surat',
            ]);

            $namaSurat = 'Surat Keputusan Direktur';

            $surat = Surat::create([
                'nama_surat' => $namaSurat,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'id_template_surat' => $request->template_id,
                'id_regulasi' => null,
                'created_by' => auth()->id(),
            ]);

            Log::info('Surat created', ['id' => $surat->id_surat, 'surat' => $surat->toArray()]);

            $memutuskanArray = is_array($request->memutuskan) ? $request->memutuskan : [];
            $labels = ['KESATU', 'KEDUA', 'KETIGA', 'KEEMPAT', 'KELIMA', 'KEENAM', 'KETUJUH', 'KEDELAPAN', 'KESEMBILAN', 'KESEPULUH'];
            $memutuskanText = '';
            $actualIndex = 0;
            foreach ($memutuskanArray as $item) {
                $item = trim((string) $item);
                if ($item === '') {
                    continue;
                }
                $label = $labels[$actualIndex] ?? 'Ke-' . ($actualIndex + 1);
                $memutuskanText .= $label . "\n" . $item . "\n\n";
                $actualIndex++;
            }

            $mengingatArray = $request->mengingat;
            $mengingatText = '';
            foreach ($mengingatArray as $index => $item) {
                $mengingatText .= ($index + 1) . ". " . trim($item) . "\n";
            }

            $menimbangArray = $request->menimbang;
            $menimbangText = implode("\n", array_map('trim', $menimbangArray));

            $mengingatArray = is_array($request->mengingat) ? $request->mengingat : [];
            $mengingatText = implode("\n", array_map(function ($id, $index) {
                return ($index + 1) . '. ' . $id;
            }, $mengingatArray, array_keys($mengingatArray)));

            $skDirektur = SKDirektur::create([
                'judul_surat' => 'KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG',
                'nomor_surat' => $request->nomor_surat,
                'tentang' => $request->tentang,
                'menimbang' => trim($menimbangText),
                'mengingat' => trim($mengingatText),
                'memutuskan' => trim($memutuskanText),
                'menetapkan' => $request->menetapkan,
                'tempat_dibuat' => $request->tempat_dibuat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'id_surat' => $surat->id_surat,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat Keputusan Direktur berhasil dibuat',
                    'surat_id' => $surat->id_surat,
                    'nomor_surat' => $surat->nomor_surat,
                    'tanggal_dibuat' => \Carbon\Carbon::parse($surat->tanggal_dibuat)->format('Y-m-d'),
                    'file_url' => route('template-surat.sk-direktur.file', $surat->id_surat),
                ]);
            }

            return redirect()->route('draft-surat.sk-direktur.index')->with('success', 'Draft Surat Keputusan Direktur berhasil dibuat');
        } catch (ValidationException $e) {
            Log::warning('Validation failed for store', [
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors(),
                ], 422);
            }

            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (Exception $e) {
            if (method_exists($e, 'errors')) {
                Log::warning('Validation-like exception in store', [
                    'errors' => $e->errors(),
                    'message' => $e->getMessage(),
                    'input' => $request->all(),
                ]);
            } else {
                Log::error('Error creating Surat Keputusan Direktur: ' . $e->getMessage(), [
                    'exception' => $e,
                    'input' => $request->all(),
                ]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat surat keputusan direktur. Silakan coba lagi');
        }
    }

    public function file(Request $request, $id)
    {
        $surat = Surat::with('template', 'sop', 'skDirektur')->findOrFail($id);
        $path = $this->ensurePdfExists($surat);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf';

        if (str_contains($templateName, 'SK Direktur') || $surat->nama_surat === 'Surat Keputusan Direktur') {
            $filename = 'SK Direktur-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';
        } elseif (str_contains($templateName, 'SOP') || $surat->nama_surat === 'Standar Operasional Prosedur (SOP)') {
            $sop = $surat->sop;
            $nomor = ($sop && $sop->nomor_dokumen) ? $sop->nomor_dokumen : $surat->nomor_surat;
            $filename = 'SOP-' . str_replace(['/', '\\'], '-', $nomor) . '.pdf';
        }

        if ($request->query('download') == '1') {
            return response()->download($path, $filename);
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function destroy(TemplateSurat $template_surat)
    {
        try {
            $templateName = $template_surat->nama_template_surat;

            if (stripos($template_surat->nama_template_surat, 'Direktur') === false) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Template bukan SK Direktur',
                    ], 403);
                }
                return redirect()->back()->with('error', 'Template bukan SK Direktur');
            }

            $template_surat->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat Keputusan Direktur berhasil dihapus',
                    'name' => $templateName,
                ]);
            }

            return redirect()->back()->with('success', 'Surat Keputusan Direktur berhasil dihapus');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus template: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus template');
        }
    }


    public function archive($id)
    {
        try {
            $surat = Surat::with('skDirektur')->findOrFail($id);
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
        try {
            $surat = Surat::with('skDirektur')->findOrFail($id);

            if (!$surat->skDirektur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Surat ini bukan SK Direktur'
                ], 400);
            }

            if ($surat->skDirektur) {
                $surat->skDirektur->menimbang_array = explode("\n", $surat->skDirektur->menimbang);

                $mengingatText = trim($surat->skDirektur->mengingat);
                $mengingatArray = [];
                if (!empty($mengingatText)) {
                    $items = preg_split('/\r\n|\r|\n/', $mengingatText);
                    foreach ($items as $item) {
                        if (preg_match('/^\d+\.\s*(\d+)/', trim($item), $matches)) {
                            $mengingatArray[] = (int) $matches[1];
                        }
                    }
                }
                $surat->skDirektur->setAttribute('mengingat_array', $mengingatArray);

                $memutuskanLines = explode("\n\n", $surat->skDirektur->memutuskan);
                $surat->skDirektur->memutuskan_array = array_map(function ($block) {
                    $lines = explode("\n", $block);
                    return isset($lines[1]) ? trim($lines[1]) : '';
                }, $memutuskanLines);

                $surat->skDirektur->tanggal_dibuat_formatted = optional($surat->skDirektur->tanggal_dibuat)->format('Y-m-d');
            }

            return response()->json([
                'success' => true,
                'data' => $surat
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data draft: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $surat = Surat::with('skDirektur')->findOrFail($id);

            $request->validate([
                'nomor_surat' => [
                    'required',
                    Rule::unique('surat', 'nomor_surat')
                        ->ignore($id, 'id_surat')
                        ->where(function ($query) use ($surat) {
                            return $query->where('id_template_surat', $surat->id_template_surat);
                        })
                ],
                'tentang' => 'required',
                'menimbang' => 'required|array|min:1',
                'menimbang.*' => 'required|string',
                'mengingat' => 'required|array|min:1',
                'mengingat.*' => 'required|string',
                'menetapkan' => 'nullable|string',
                'memutuskan' => 'nullable|array',
                'memutuskan.0' => 'nullable|string',
                'memutuskan.*' => 'nullable|string',
                'tempat_dibuat' => 'required',
                'tanggal_dibuat' => 'required|date',
            ]);

            if ($surat->file_path && file_exists(storage_path('app/' . $surat->file_path))) {
                unlink(storage_path('app/' . $surat->file_path));
            }

            DB::beginTransaction();

            $surat->update([
                'nomor_surat' => $request->nomor_surat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'file_path' => null,
            ]);

            $memutuskanArray = is_array($request->memutuskan) ? $request->memutuskan : [];
            $labels = ['KESATU', 'KEDUA', 'KETIGA', 'KEEMPAT', 'KELIMA', 'KEENAM', 'KETUJUH', 'KEDELAPAN', 'KESEMBILAN', 'KESEPULUH'];
            $memutuskanText = '';
            $actualIndex = 0;
            foreach ($memutuskanArray as $item) {
                $item = trim((string) $item);
                if ($item === '') {
                    continue;
                }
                $label = $labels[$actualIndex] ?? 'Ke-' . ($actualIndex + 1);
                $memutuskanText .= $label . "\n" . $item . "\n\n";
                $actualIndex++;
            }

            $mengingatArray = $request->mengingat;
            $mengingatText = implode("\n", array_map(function ($id, $index) {
                return ($index + 1) . '. ' . $id;
            }, $mengingatArray, array_keys($mengingatArray)));

            $menimbangText = implode("\n", array_map('trim', $request->menimbang));

            $defaultTitle = optional($surat->skDirektur)->judul_surat
                ?: 'KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG';

            $surat->skDirektur()->updateOrCreate(
                [],
                [
                    'judul_surat' => $defaultTitle,
                    'nomor_surat' => $request->nomor_surat,
                    'tentang' => $request->tentang,
                    'menimbang' => trim($menimbangText),
                    'mengingat' => trim($mengingatText),
                    'memutuskan' => trim($memutuskanText),
                    'menetapkan' => $request->menetapkan,
                    'tempat_dibuat' => $request->tempat_dibuat,
                    'tanggal_dibuat' => $request->tanggal_dibuat,
                ]
            );

            DB::commit();

            $surat->refresh();
            $surat->load('createdBy.ruangan', 'skDirektur');

            return response()->json([
                'success' => true,
                'message' => 'Draft Surat Keputusan Direktur berhasil diperbarui',
                'data' => $surat
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui draft: ' . implode(', ', $e->validator->errors()->all()),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui draft: ' . $e->getMessage()
            ], 500);
        }
    }
}
