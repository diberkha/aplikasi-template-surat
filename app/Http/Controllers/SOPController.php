<?php

namespace App\Http\Controllers;

use App\Models\SOP;
use App\Models\SOPContent;
use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\Unit;
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

        $regulasis = \App\Models\Regulasi::all();
        $units = Unit::all();
        return view('template-surat.sop.index', compact('templates', 'regulasis', 'units'));
    }

    public function store(Request $request)
    {
        Log::info('SOP Store Request Data:', $request->all());
        try {
            if ($request->has('contents.0')) {
                $firstPage = $request->input('contents.0');
                if (!$request->filled('judul_sop'))
                    $request->merge(['judul_sop' => $firstPage['judul_sop'] ?? null]);
                if (!$request->filled('nomor_dokumen'))
                    $request->merge(['nomor_dokumen' => $firstPage['nomor_dokumen'] ?? null]);
                if (!$request->filled('tanggal_terbit'))
                    $request->merge(['tanggal_terbit' => $firstPage['tanggal_terbit'] ?? null]);
                if (!$request->filled('pengertian'))
                    $request->merge(['pengertian' => $firstPage['pengertian'] ?? null]);
                if (!$request->has('tujuan'))
                    $request->merge(['tujuan' => $firstPage['tujuan'] ?? []]);
                if (!$request->has('kebijakan'))
                    $request->merge(['kebijakan' => $firstPage['kebijakan'] ?? []]);
                if (!$request->has('prosedur'))
                    $request->merge(['prosedur' => $firstPage['prosedur'] ?? []]);
                if (!$request->has('unit_terkait'))
                    $request->merge(['unit_terkait' => $firstPage['unit_terkait'] ?? []]);
            }

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
            ], [
                'nomor_dokumen.unique' => 'Nomor dokumen duplikat',
                'nomor_dokumen.required' => 'Nomor dokumen wajib diisi',
                'judul_sop.required' => 'Judul SOP wajib diisi',
                'tanggal_terbit.required' => 'Tanggal terbit wajib diisi',
                'pengertian.required' => 'Pengertian wajib diisi',
                'tujuan.required' => 'Tujuan wajib diisi',
                'tujuan.min' => 'Tujuan minimal 1 item',
                'kebijakan.required' => 'Kebijakan wajib diisi',
                'kebijakan.min' => 'Kebijakan minimal 1 item',
                'prosedur.required' => 'Prosedur wajib diisi',
                'prosedur.min' => 'Prosedur minimal 1 item',
                'unit_terkait.required' => 'Unit terkait wajib diisi',
                'unit_terkait.min' => 'Unit terkait minimal 1 item',
            ]);

            $allRequestedNumbers = collect($request->input('contents', []))
                ->pluck('nomor_dokumen')
                ->push($request->nomor_dokumen)
                ->filter()
                ->unique();

            foreach ($allRequestedNumbers as $num) {
                $existsOther = \App\Models\SOPContent::where('nomor_dokumen', $num)
                    ->whereHas('sop', function ($q) {
                    })->exists();

                if ($existsOther) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'nomor_dokumen' => ["Nomor dokumen duplikat"]
                    ]);
                }
            }

            DB::beginTransaction();

            $surat = Surat::create([
                'nama_surat' => 'Standar Operasional Prosedur',
                'nomor_surat' => $request->nomor_dokumen,
                'tanggal_dibuat' => $request->tanggal_terbit,
                'id_template_surat' => $request->template_id,
                'id_regulasi' => null,
                'created_by' => auth()->id(),
            ]);

            $sop = SOP::create([
                'id_surat' => $surat->id_surat,
            ]);

            $pagesData = $request->input('contents', []);
            if (empty($pagesData)) {
                $pagesData = [
                    [
                        'judul_sop' => $request->judul_sop,
                        'nomor_dokumen' => $request->nomor_dokumen,
                        'nomor_revisi' => $request->nomor_revisi,
                        'halaman' => $request->filled('halaman') ? $request->halaman : '1/1',
                        'tanggal_terbit' => $request->tanggal_terbit,
                        'pengertian' => $request->pengertian,
                        'tujuan' => $request->tujuan,
                        'kebijakan' => $request->kebijakan,
                        'prosedur' => $request->prosedur,
                        'unit_terkait' => $request->unit_terkait,
                    ]
                ];
            }

            foreach ($pagesData as $index => $page) {
                $kebijakanArray = is_array($page['kebijakan'] ?? []) ? $page['kebijakan'] : [];
                $kebijakanText = implode("\n", array_map(function ($id, $i) {
                    return ($i + 1) . '. ' . $id;
                }, $kebijakanArray, array_keys($kebijakanArray)));

                $unitArray = is_array($page['unit_terkait'] ?? []) ? $page['unit_terkait'] : [];
                $unitText = implode("\n", array_map(function ($id, $i) {
                    return ($i + 1) . '. ' . $id;
                }, $unitArray, array_keys($unitArray)));

                $tujuanText = is_array($page['tujuan'] ?? []) ? implode("\n", array_filter(array_map('trim', (array) $page['tujuan']))) : trim($page['tujuan'] ?? '');
                $prosedurText = is_array($page['prosedur'] ?? []) ? implode("\n", array_filter(array_map('trim', (array) $page['prosedur']))) : trim($page['prosedur'] ?? '');

                $sop->contents()->create([
                    'judul_sop' => $page['judul_sop'] ?? $request->judul_sop,
                    'nomor_dokumen' => $page['nomor_dokumen'] ?? $request->nomor_dokumen,
                    'nomor_revisi' => $page['nomor_revisi'] ?? $request->nomor_revisi ?? '',
                    'halaman' => $page['halaman'] ?? (($index + 1) . '/' . count($pagesData)),
                    'tanggal_terbit' => $page['tanggal_terbit'] ?? $request->tanggal_terbit,
                    'pengertian' => trim($page['pengertian'] ?? $request->pengertian ?? ''),
                    'tujuan' => $tujuanText,
                    'kebijakan' => trim($kebijakanText),
                    'prosedur' => $prosedurText,
                    'unit_terkait' => trim($unitText),
                ]);
            }

            DB::commit();

            if ($request->expectsJson()) {
                $surat->refresh()->load(['sop.contents']);
                return response()->json([
                    'success' => true,
                    'message' => 'Standar Operasional Prosedur berhasil dibuat',
                    'data' => [
                        'id_surat' => $surat->id_surat,
                        'nama_surat' => $surat->nama_surat,
                        'nomor_surat' => $surat->nomor_surat,
                        'created_at' => $surat->created_at->toDateTimeString(),
                        'username' => auth()->user()->username ?? 'Unknown',
                        'ruangan' => auth()->user()->ruangan->nama_ruangan ?? '-',
                        'sop' => $surat->sop ? [
                            'id_sop' => $surat->sop->id_sop,
                            'judul_sop' => $surat->sop->contents->first()->judul_sop ?? $surat->nama_surat,
                            'nomor_dokumen' => $surat->sop->contents->first()->nomor_dokumen ?? $surat->nomor_surat,
                        ] : null,
                    ],
                    'surat_id' => $surat->id_surat,
                    'nomor_surat' => $surat->nomor_surat,
                    'tanggal_dibuat' => optional($surat->tanggal_dibuat)->format('Y-m-d'),
                    'judul_sop' => $surat->sop->contents->first()->judul_sop ?? $surat->nama_surat,
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
            
            $path = $this->generatePdfContent($surat, true);
            
            if (!$path || !file_exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat file PDF surat'
                ], 500);
            }
            
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
            $surat = Surat::with(['sop.contents', 'template'])->findOrFail($id);

            if (!$surat->sop) {
                if ($surat->template && (stripos($surat->template->nama_template_surat, 'SOP') !== false || stripos($surat->template->nama_template_surat, 'Standar Operasional') !== false)) {
                    $surat->sop()->create();
                    $surat->load(['sop.contents']);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Surat ini bukan SOP'
                    ], 400);
                }
            }

            $pages = $surat->sop->contents->values();

            if ($pages->isEmpty()) {
                $virtualPage = new \App\Models\SOPContent([
                    'judul_sop' => $surat->nama_surat ?? '',
                    'nomor_dokumen' => $surat->nomor_surat ?? '',
                    'halaman' => '1/1',
                    'tanggal_terbit' => $surat->tanggal_dibuat ?? now(),
                    'pengertian' => '',
                    'tujuan' => '',
                    'kebijakan' => '',
                    'prosedur' => '',
                    'unit_terkait' => '',
                ]);
                $pages = collect([$virtualPage]);
                $surat->sop->setRelation('contents', $pages);
            }

            return response()->json([
                'success' => true,
                'data' => $surat
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage() . ' at line ' . $e->getLine()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $surat = Surat::with('sop')->findOrFail($id);

            if ($request->has('pages.0')) {
                $firstPage = $request->input('pages.0');
                if (!$request->filled('judul_sop'))
                    $request->merge(['judul_sop' => $firstPage['judul_sop'] ?? null]);
                if (!$request->filled('nomor_dokumen'))
                    $request->merge(['nomor_dokumen' => $firstPage['nomor_dokumen'] ?? null]);
                if (!$request->filled('tanggal_terbit'))
                    $request->merge(['tanggal_terbit' => $firstPage['tanggal_terbit'] ?? null]);
                if (!$request->filled('pengertian'))
                    $request->merge(['pengertian' => $firstPage['pengertian'] ?? null]);
                if (!$request->has('tujuan'))
                    $request->merge(['tujuan' => $firstPage['tujuan'] ?? []]);
                if (!$request->has('kebijakan'))
                    $request->merge(['kebijakan' => $firstPage['kebijakan'] ?? []]);
                if (!$request->has('prosedur'))
                    $request->merge(['prosedur' => $firstPage['prosedur'] ?? []]);
                if (!$request->has('unit_terkait'))
                    $request->merge(['unit_terkait' => $firstPage['unit_terkait'] ?? []]);
            }

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
            ], [
                'nomor_dokumen.unique' => 'Nomor dokumen duplikat',
                'nomor_dokumen.required' => 'Nomor dokumen wajib diisi',
                'judul_sop.required' => 'Judul SOP wajib diisi',
                'tanggal_terbit.required' => 'Tanggal terbit wajib diisi',
                'pengertian.required' => 'Pengertian wajib diisi',
                'tujuan.required' => 'Tujuan wajib diisi',
                'tujuan.min' => 'Tujuan minimal 1 item',
                'kebijakan.required' => 'Kebijakan wajib diisi',
                'kebijakan.min' => 'Kebijakan minimal 1 item',
                'prosedur.required' => 'Prosedur wajib diisi',
                'prosedur.min' => 'Prosedur minimal 1 item',
                'unit_terkait.required' => 'Unit terkait wajib diisi',
                'unit_terkait.min' => 'Unit terkait minimal 1 item',
            ]);

            $allRequestedNumbers = collect($request->input('contents', []))
                ->pluck('nomor_dokumen')
                ->push($request->nomor_dokumen)
                ->filter()
                ->unique();

            foreach ($allRequestedNumbers as $num) {
                $existsOther = \App\Models\SOPContent::where('nomor_dokumen', $num)
                    ->whereHas('sop', function ($q) use ($surat) {
                        $q->where('id_surat', '!=', $surat->id_surat);
                    })->exists();

                if ($existsOther) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'nomor_dokumen' => ["Nomor dokumen duplikat"]
                    ]);
                }
            }

            DB::beginTransaction();

            $surat->update([
                'tanggal_dibuat' => $request->tanggal_terbit,
                'nomor_surat' => $request->nomor_dokumen,
                'file_path' => null,
            ]);

            $sop = $surat->sop()->firstOrCreate([]);

            $pagesData = $request->input('contents', []);
            if (empty($pagesData)) {
                $pagesData = [
                    [
                        'judul_sop' => $request->judul_sop,
                        'nomor_dokumen' => $request->nomor_dokumen,
                        'nomor_revisi' => $request->nomor_revisi ?? '',
                        'halaman' => $request->filled('halaman') ? $request->halaman : '1/1',
                        'tanggal_terbit' => $request->tanggal_terbit,
                        'pengertian' => $request->pengertian,
                        'tujuan' => (array) $request->tujuan,
                        'kebijakan' => (array) $request->kebijakan,
                        'prosedur' => (array) $request->prosedur,
                        'unit_terkait' => (array) $request->unit_terkait,
                    ]
                ];
            }

            $sop->contents()->delete();
            foreach ($pagesData as $index => $page) {
                $kebijakanArray = is_array($page['kebijakan'] ?? []) ? $page['kebijakan'] : [];
                $kebijakanText = implode("\n", array_map(function ($id, $i) {
                    return ($i + 1) . '. ' . $id;
                }, $kebijakanArray, array_keys($kebijakanArray)));

                $unitArray = is_array($page['unit_terkait'] ?? []) ? $page['unit_terkait'] : [];
                $unitText = implode("\n", array_map(function ($id, $i) {
                    return ($i + 1) . '. ' . $id;
                }, $unitArray, array_keys($unitArray)));

                $tujuanText = is_array($page['tujuan'] ?? []) ? implode("\n", array_filter(array_map('trim', (array) $page['tujuan']))) : trim($page['tujuan'] ?? '');
                $prosedurText = is_array($page['prosedur'] ?? []) ? implode("\n", array_filter(array_map('trim', (array) $page['prosedur']))) : trim($page['prosedur'] ?? '');

                $sop->contents()->create([
                    'judul_sop' => $page['judul_sop'],
                    'nomor_dokumen' => $page['nomor_dokumen'],
                    'nomor_revisi' => $page['nomor_revisi'] ?? '',
                    'halaman' => $page['halaman'],
                    'tanggal_terbit' => $page['tanggal_terbit'],
                    'pengertian' => trim($page['pengertian']),
                    'tujuan' => $tujuanText,
                    'kebijakan' => $kebijakanText,
                    'prosedur' => $prosedurText,
                    'unit_terkait' => $unitText,
                ]);
            }

            DB::commit();

            $surat->refresh()->load(['sop.contents']);

            return response()->json([
                'success' => true,
                'message' => 'Draft SOP berhasil diperbarui',
                'data' => [
                    'id_surat' => $surat->id_surat,
                    'nama_surat' => $surat->nama_surat,
                    'nomor_surat' => $surat->nomor_surat,
                    'created_at' => $surat->created_at->toDateTimeString(),
                    'username' => auth()->user()->username ?? 'Unknown',
                    'ruangan' => auth()->user()->ruangan->nama_ruangan ?? '-',
                    'sop' => $surat->sop ? [
                        'id_sop' => $surat->sop->id_sop,
                        'judul_sop' => $surat->sop->contents->first()->judul_sop ?? $surat->nama_surat,
                        'nomor_dokumen' => $surat->sop->contents->first()->nomor_dokumen ?? $surat->nomor_surat,
                    ] : null,
                ],
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . implode(', ', collect($e->errors())->flatten()->all()),
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (Exception $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui draft: ' . $e->getMessage() . ' at ' . $e->getLine()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui draft: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            if ($surat->sop) {
                $surat->sop->contents()->delete();
                $surat->sop->delete();
            }
            $surat->delete();

            return response()->json([
                'success' => true,
                'message' => 'Draft SOP berhasil dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus draft: ' . $e->getMessage()
            ], 500);
        }
    }

    public function file(Request $request, $id)
    {
        $surat = Surat::with('sop')->findOrFail($id);
        
        if ($surat->is_draft) {
            $path = $this->generateTempPdf($surat);
        } else {
            $path = $this->ensurePdfExists($surat);
        }

        if (!$path || !file_exists($path)) {
            abort(404, 'File PDF tidak dapat dibuat atau tidak ditemukan');
        }

        $sop = $surat->sop;
        $nomor = ($sop && $sop->nomor_dokumen) ? $sop->nomor_dokumen : $surat->nomor_surat;
        $safeNomor = str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $nomor);
        $filename = 'SOP-' . $safeNomor . '.pdf';

        if ($surat->is_draft && file_exists($path)) {
            register_shutdown_function(function() use ($path) {
                if (file_exists($path)) {
                    @unlink($path);
                }
            });
        }

        if ($request->query('download') == '1') {
            return response()->download($path, $filename);
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
