<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\SuratUndangan;
use App\Models\Pegawai;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class SuratUndanganController extends Controller
{
    use \App\Traits\LazyPdfTrait;

    public function index(Request $request)
    {
        $templates = TemplateSurat::where('nama_template_surat', 'Surat Undangan')
            ->orderBy('nama_template_surat', 'asc')
            ->get()
            ->map(function ($t) {
                return [
                    'id_template_surat' => $t->id_template_surat,
                    'nama_template_surat' => $t->nama_template_surat,
                    'description' => 'Template Surat Undangan',
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

        $pegawais = Pegawai::orderBy('nama', 'asc')->get();
        return view('template-surat.surat-undangan.index', compact('templates', 'pegawais'));
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
                'lampiran' => 'nullable|string',
                'hal' => 'required|string',
                'kepada' => 'required|string',
                'tempat_dibuat' => 'required|string',
                'tanggal_dibuat' => 'required|date',
                'hari_acara' => 'required|string',
                'tanggal_acara' => 'required|date',
                'nama_kegiatan' => 'required|string',
                'jam_mulai' => 'required|string',
                'jam_selesai' => 'nullable|string',
                'keterangan_waktu' => 'nullable|string',
                'tempat_acara' => 'required|string',
                'keperluan' => 'nullable|string',
                'nama_tertanda' => 'required|string',
                'nip_tertanda' => 'required|string',
                'jabatan_tertanda' => 'required|string',
                'template_id' => 'required|exists:template_surat,id_template_surat',
            ], [
                'nomor_surat.unique' => 'Nomor surat duplikat',
                'nomor_surat.required' => 'Nomor surat wajib diisi',
                'jabatan_tertanda.required' => 'Jabatan tertanda wajib diisi',
            ]);

            $namaSurat = $request->nama_kegiatan;

            $surat = Surat::create([
                'nama_surat' => $namaSurat,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'id_template_surat' => $request->template_id,
                'id_regulasi' => null,
                'created_by' => auth()->id(),
            ]);

            Log::info('Surat created', ['id' => $surat->id_surat, 'surat' => $surat->toArray()]);

            SuratUndangan::create([
                'nomor_surat' => $request->nomor_surat,
                'lampiran' => $request->lampiran,
                'hal' => $request->hal,
                'kepada' => $request->kepada,
                'tempat_dibuat' => $request->tempat_dibuat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'hari_acara' => $request->hari_acara,
                'tanggal_acara' => $request->tanggal_acara,
                'nama_kegiatan' => $request->nama_kegiatan,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'keterangan_waktu' => $request->keterangan_waktu,
                'tempat_acara' => $request->tempat_acara,
                'keperluan' => $request->keperluan,
                'nama_tertanda' => $request->nama_tertanda,
                'nip_tertanda' => $request->nip_tertanda,
                'jabatan_tertanda' => $request->jabatan_tertanda,
                'id_surat' => $surat->id_surat,
            ]);

            if ($request->expectsJson()) {
                $surat->load('suratUndangan');
                return response()->json([
                    'success' => true,
                    'message' => 'Surat Undangan berhasil dibuat',
                    'surat_id' => $surat->id_surat,
                    'nomor_surat' => $surat->nomor_surat,
                    'tanggal_dibuat' => \Carbon\Carbon::parse($surat->tanggal_dibuat)->format('Y-m-d'),
                    'file_url' => route('template-surat.surat-undangan.file', $surat->id_surat),
                    'data' => $surat,
                ]);
            }

            return redirect()->route('draft-surat.surat-undangan.index')->with('success', 'Draft Surat Undangan berhasil dibuat');
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
            Log::error('Error creating Surat Undangan: ' . $e->getMessage(), [
                'exception' => $e,
                'input' => $request->all(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat surat undangan. Silakan coba lagi');
        }
    }

    public function file(Request $request, $id)
    {
        try {
            $surat = Surat::with('template', 'suratUndangan')->findOrFail($id);
            
            if ($surat->is_draft) {
                $path = $this->generateTempPdf($surat);
            } else {
                $path = $this->ensurePdfExists($surat);
            }

            if (!$path || !file_exists($path)) {
                abort(404, 'File tidak ditemukan');
            }

            $filename = 'Surat Undangan-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';

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
        } catch (\Exception $e) {
            Log::error('Error generating PDF for surat ' . $id . ': ' . $e->getMessage(), ['exception' => $e]);
            abort(500, 'Gagal membuat file: ' . $e->getMessage());
        }
    }

    public function destroy(TemplateSurat $template_surat)
    {
        try {
            $templateName = $template_surat->nama_template_surat;

            if (stripos($template_surat->nama_template_surat, 'Undangan') === false) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Template bukan Surat Undangan',
                    ], 403);
                }
                return redirect()->back()->with('error', 'Template bukan Surat Undangan');
            }

            $template_surat->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat Undangan berhasil dihapus',
                    'name' => $templateName,
                ]);
            }

            return redirect()->back()->with('success', 'Surat Undangan berhasil dihapus');
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
            $surat = Surat::with('suratUndangan')->findOrFail($id);
            
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
            $surat = Surat::with('suratUndangan')->findOrFail($id);

            if (!$surat->suratUndangan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Surat ini bukan Surat Undangan'
                ], 400);
            }

            if ($surat->suratUndangan) {
                $surat->suratUndangan->tanggal_dibuat_formatted = optional($surat->suratUndangan->tanggal_dibuat)->format('Y-m-d');
                $surat->suratUndangan->tanggal_acara_formatted = optional($surat->suratUndangan->tanggal_acara)->format('Y-m-d');
                if (!$surat->suratUndangan->hari_acara && $surat->suratUndangan->tanggal_acara_formatted) {
                    $dateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $surat->suratUndangan->tanggal_acara_formatted);
                    $hariList = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $surat->suratUndangan->hari_acara = $hariList[$dateObj->dayOfWeek];
                }
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
            $surat = Surat::with('suratUndangan')->findOrFail($id);

            $request->validate([
                'nomor_surat' => [
                    'required',
                    Rule::unique('surat', 'nomor_surat')
                        ->ignore($id, 'id_surat')
                        ->where(function ($query) use ($surat) {
                            return $query->where('id_template_surat', $surat->id_template_surat);
                        })
                ],
                'lampiran' => 'nullable|string',
                'hal' => 'required|string',
                'kepada' => 'required|string',
                'tempat_dibuat' => 'required|string',
                'tanggal_dibuat' => 'required|date',
                'hari_acara' => 'required|string',
                'tanggal_acara' => 'required|date',
                'nama_kegiatan' => 'required|string',
                'jam_mulai' => 'required|string',
                'jam_selesai' => 'nullable|string',
                'keterangan_waktu' => 'nullable|string',
                'tempat_acara' => 'required|string',
                'keperluan' => 'nullable|string',
                'nama_tertanda' => 'required|string',
                'nip_tertanda' => 'required|string',
                'jabatan_tertanda' => 'required|string',
            ], [
                'nomor_surat.unique' => 'Nomor surat duplikat',
                'nomor_surat.required' => 'Nomor surat wajib diisi',
                'hal.required' => 'Hal wajib diisi',
                'kepada.required' => 'Kepada wajib diisi',
                'tempat_dibuat.required' => 'Tempat dibuat wajib diisi',
                'tanggal_dibuat.required' => 'Tanggal dibuat wajib diisi',
                'hari_acara.required' => 'Hari acara wajib diisi',
                'tanggal_acara.required' => 'Tanggal acara wajib diisi',
                'nama_kegiatan.required' => 'Nama kegiatan wajib diisi',
                'jam_mulai.required' => 'Jam mulai wajib diisi',
                'tempat_acara.required' => 'Tempat acara wajib diisi',
                'nama_tertanda.required' => 'Nama tertanda wajib diisi',
                'nip_tertanda.required' => 'NIP tertanda wajib diisi',
                'jabatan_tertanda.required' => 'Jabatan tertanda wajib diisi',
            ]);

            if ($surat->file_path && file_exists(storage_path('app/' . $surat->file_path))) {
                unlink(storage_path('app/' . $surat->file_path));
            }

            DB::beginTransaction();

            $surat->update([
                'nama_surat' => $request->nama_kegiatan,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'file_path' => null,
            ]);

            $surat->suratUndangan()->updateOrCreate(
                [],
                [
                    'nomor_surat' => $request->nomor_surat,
                    'lampiran' => $request->lampiran,
                    'hal' => $request->hal,
                    'kepada' => $request->kepada,
                    'tempat_dibuat' => $request->tempat_dibuat,
                    'tanggal_dibuat' => $request->tanggal_dibuat,
                    'hari_acara' => $request->hari_acara,
                    'tanggal_acara' => $request->tanggal_acara,
                    'nama_kegiatan' => $request->nama_kegiatan,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                    'keterangan_waktu' => $request->keterangan_waktu,
                    'tempat_acara' => $request->tempat_acara,
                    'keperluan' => $request->keperluan,
                    'nama_tertanda' => $request->nama_tertanda,
                    'nip_tertanda' => $request->nip_tertanda,
                    'jabatan_tertanda' => $request->jabatan_tertanda,
                ]
            );

            DB::commit();

            $surat->refresh();
            $surat->load('createdBy.ruangan', 'suratUndangan');

            return response()->json([
                'success' => true,
                'message' => 'Draft Surat Undangan berhasil diperbarui',
                'surat_id' => $surat->id_surat,
                'nomor_surat' => $surat->nomor_surat,
                'tanggal_dibuat' => \Carbon\Carbon::parse($surat->tanggal_dibuat)->format('Y-m-d'),
                'file_url' => route('template-surat.surat-undangan.file', $surat->id_surat),
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
