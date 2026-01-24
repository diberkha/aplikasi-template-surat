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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class SOPController extends Controller
{
    use \App\Traits\LazyPdfTrait;
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
                'nomor_dokumen' => [
                    'required',
                    'string',
                    Rule::unique('surat', 'nomor_surat')->where(function ($query) use ($request) {
                        return $query->where('id_template_surat', $request->template_id);
                    })
                ],
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
                'nomor_surat' => $request->nomor_dokumen,
                'tanggal_dibuat' => $request->tanggal_terbit,
                'id_template_surat' => $request->template_id,
                'id_regulasi' => null,
                'created_by' => auth()->id(),
            ]);

            $kebijakanArray = is_array($request->kebijakan) ? $request->kebijakan : [];
            $kebijakanText = implode("\n", array_map(function ($id, $index) {
                return ($index + 1) . '. ' . $id;
            }, $kebijakanArray, array_keys($kebijakanArray)));
            
            $unitArray = is_array($request->unit_terkait) ? $request->unit_terkait : [];
            $unitText = implode("\n", array_map(function ($id, $index) {
                return ($index + 1) . '. ' . $id;
            }, $unitArray, array_keys($unitArray)));

            $tujuanText = implode("\n", array_filter($request->tujuan));
            $prosedurText = implode("\n", array_filter($request->prosedur));

            SOP::create([
                'id_surat' => $surat->id_surat,
                'judul_sop' => $request->judul_sop,
                'nomor_dokumen' => $request->nomor_dokumen,
                'nomor_revisi' => $request->nomor_revisi,
                'halaman' => $request->filled('halaman') ? $request->halaman : '1',
                'tanggal_terbit' => $request->tanggal_terbit,
                'pengertian' => $request->pengertian,
                'tujuan' => $tujuanText,
                'kebijakan' => trim($kebijakanText),
                'prosedur' => $prosedurText,
                'unit_terkait' => trim($unitText),
            ]);

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
            $surat = Surat::with('sop')->findOrFail($id);
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
            $surat = Surat::with('sop')->findOrFail($id);

            if (!$surat->sop) {
                return response()->json([
                    'success' => false,
                    'message' => 'Surat ini bukan SOP'
                ], 400);
            }

            if ($surat->sop) {
                $surat->sop->tujuan_array = explode("\n", $surat->sop->tujuan);
                $surat->sop->prosedur_array = explode("\n", $surat->sop->prosedur);

                $kebijakanText = trim($surat->sop->kebijakan);
                $kebijakanArray = [];
                if (!empty($kebijakanText)) {
                    $items = preg_split('/\r\n|\r|\n/', $kebijakanText);
                    foreach ($items as $item) {
                        if (preg_match('/^\d+\.\s*(\d+)/', trim($item), $matches)) {
                            $kebijakanArray[] = (int)$matches[1];
                        }
                    }
                }
                $surat->sop->setAttribute('kebijakan_array', $kebijakanArray);

                $unitText = trim($surat->sop->unit_terkait);
                $unitArray = [];
                if (!empty($unitText)) {
                    $items = preg_split('/\r\n|\r|\n/', $unitText);
                    foreach ($items as $item) {
                        if (preg_match('/^\d+\.\s*(\d+)/', trim($item), $matches)) {
                            $unitArray[] = (int)$matches[1];
                        }
                    }
                }
                $surat->sop->setAttribute('unit_terkait_array', $unitArray);

                $surat->sop->tanggal_terbit_formatted = optional($surat->sop->tanggal_terbit)->format('Y-m-d');
            }

            return response()->json([
                'success' => true,
                'data' => $surat
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $surat = Surat::with('sop')->findOrFail($id);

            $request->validate([
                'judul_sop' => 'required|string',
                'nomor_dokumen' => [
                    'required',
                    'string',
                    Rule::unique('surat', 'nomor_surat')
                        ->where(function ($query) use ($surat) {
                            return $query->where('id_template_surat', $surat->id_template_surat);
                        })
                        ->ignore($id, 'id_surat')
                ],
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

            DB::beginTransaction();

            $surat->update([
                'tanggal_dibuat' => $request->tanggal_terbit,
            ]);

            $kebijakanArray = is_array($request->kebijakan) ? $request->kebijakan : [];
            $kebijakanText = implode("\n", array_map(function ($id, $index) {
                return ($index + 1) . '. ' . $id;
            }, $kebijakanArray, array_keys($kebijakanArray)));

            $unitArray = is_array($request->unit_terkait) ? $request->unit_terkait : [];
            $unitText = implode("\n", array_map(function ($id, $index) {
                return ($index + 1) . '. ' . $id;
            }, $unitArray, array_keys($unitArray)));

            $tujuanText = implode("\n", array_filter($request->tujuan));
            $prosedurText = implode("\n", array_filter($request->prosedur));

            $surat->update([
                'nomor_surat' => $request->nomor_dokumen,
                'file_path' => null,
            ]);

            $surat->sop()->updateOrCreate(
                [],
                [
                    'judul_sop' => $request->judul_sop,
                    'nomor_dokumen' => $request->nomor_dokumen,
                    'nomor_revisi' => $request->nomor_revisi,
                    'halaman' => $request->filled('halaman') ? $request->halaman : '1',
                    'tanggal_terbit' => $request->tanggal_terbit,
                    'pengertian' => $request->pengertian,
                    'tujuan' => $tujuanText,
                    'kebijakan' => trim($kebijakanText),
                    'prosedur' => $prosedurText,
                    'unit_terkait' => trim($unitText),
                ]
            );

            DB::commit();

            $surat->refresh();
            $surat->load('createdBy.ruangan', 'sop');

            return response()->json([
                'success' => true,
                'message' => 'Draft SOP berhasil diperbarui',
                'data' => $surat
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui draft: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui draft: ' . $e->getMessage()
            ], 500);
        }
    }
    public function file(Request $request, $id)
    {
        $surat = Surat::with('sop')->findOrFail($id);
        $path = $this->ensurePdfExists($surat);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        $sop = $surat->sop;
        $nomor = ($sop && $sop->nomor_dokumen) ? $sop->nomor_dokumen : $surat->nomor_surat;
        $safeNomor = str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $nomor);
        $filename = 'SOP-' . $safeNomor . '.pdf';

        if ($request->query('download') == '1') {
            return response()->download($path, $filename);
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
