<?php
namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\SuratIzinCuti;
use App\Models\Pegawai;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class IzinCutiController extends Controller
{
    public function index(Request $request)
    {
        $templates = TemplateSurat::whereIn('nama_template_surat', [
            'Surat Izin Cuti PNS',
            'Surat Izin Cuti PPPK',
            'Surat Izin Cuti Non ASN'
        ])
            ->orderBy('nama_template_surat', 'asc')
            ->get()
            ->map(function ($t) {
                $desc = 'Template Surat Izin Cuti PNS';
                if (stripos($t->nama_template_surat, 'PPPK') !== false) {
                    $desc = 'Template Surat Izin Cuti PPPK';
                } elseif (stripos($t->nama_template_surat, 'Non ASN') !== false) {
                    $desc = 'Template Surat Izin Cuti Non ASN';
                }

                return [
                    'id_template_surat' => $t->id_template_surat,
                    'nama_template_surat' => $t->nama_template_surat,
                    'description' => $desc,
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
        $pegawais = \App\Models\Pegawai::orderBy('nama', 'asc')->get();
        return view('template-surat.cuti.index', compact('templates', 'regulasis', 'pegawais'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kategori' => 'required|in:PNS,PPPK,NON ASN',
                'template_id' => 'required|exists:template_surat,id_template_surat',
                'form' => 'required|array',
                'form.tanggal_surat' => 'required|date',
                'form.nama_atasan' => 'required|string',
            ], [
                'kategori.required' => 'Kategori wajib diisi',
                'kategori.in' => 'Kategori tidak valid',
                'form.required' => 'Form wajib diisi',
                'form.tanggal_surat.required' => 'Tanggal surat wajib diisi',
                'form.nama_atasan.required' => 'Nama atasan wajib diisi',
            ]);

            $kategori = strtoupper($request->kategori);
            $namaPegawai = strtoupper(trim($request->input('form.nama') ?? 'DRAFT'));

            $prefixPattern = 'CUTI-' . $kategori . '-' . $namaPegawai . '-';
            $lastSurat = Surat::where('nomor_surat', 'like', $prefixPattern . '%')
                ->orderByRaw('CAST(SUBSTRING_INDEX(nomor_surat, "-", -1) AS UNSIGNED) DESC')
                ->first();

            $sequence = 1;
            if ($lastSurat) {
                $lastNomor = $lastSurat->nomor_surat;
                $lastParts = explode('-', $lastNomor);
                $lastSuffix = end($lastParts);
                $sequence = (int) $lastSuffix + 1;
            }

            $uniqueNomor = $prefixPattern . str_pad($sequence, 3, '0', STR_PAD_LEFT);

            $surat = Surat::create([
                'nama_surat' => 'Surat Izin Cuti',
                'nomor_surat' => $uniqueNomor,
                'tanggal_dibuat' => $request->input('form.tanggal_surat'),
                'id_template_surat' => $request->template_id,
                'id_regulasi' => null,
                'created_by' => auth()->id(),
            ]);

            $cuti = SuratIzinCuti::create([
                'id_surat' => $surat->id_surat,
                'kategori' => $request->kategori,
                'form_data' => $request->form,
            ]);

            if (isset($request->form['jenis_cuti']) && $request->form['jenis_cuti'] == 'Cuti Tahunan') {
                $lamaCuti = (int) ($request->form['lama_cuti'] ?? 0);
                $nip = $request->form['nip'] ?? null;
                $nip = $request->form['nip'] ?? null;
                $pegawaiId = $request->form['pegawai_id'] ?? null;
                $pegawai = null;

                if ($pegawaiId) {
                    $pegawai = \App\Models\Pegawai::find($pegawaiId);
                } elseif ($nip) {
                    $pegawai = \App\Models\Pegawai::where('nip', $nip)->first();
                } else {
                    $nama = $request->form['nama'] ?? null;
                    if ($nama) {
                        $pegawai = \App\Models\Pegawai::where('nama', $nama)->first();
                    }
                }

                if ($pegawai) {
                    if ($kategori === 'PNS') {
                        $n2_used = 0;
                        $n1_used = 0;
                        $n_used = 0;

                        $remainingToSubtract = $lamaCuti;

                        $request->merge([
                            'form' => array_merge($request->form, [
                                'catatan_n2_awal' => $pegawai->sisa_cuti_n2,
                                'catatan_n1_awal' => $pegawai->sisa_cuti_n1,
                                'catatan_n_awal' => $pegawai->sisa_cuti_n,
                            ])
                        ]);

                        if ($remainingToSubtract > 0 && $pegawai->sisa_cuti_n2 > 0) {
                            $deduct = min($remainingToSubtract, $pegawai->sisa_cuti_n2);
                            $pegawai->sisa_cuti_n2 -= $deduct;
                            $remainingToSubtract -= $deduct;
                            $n2_used = $deduct;
                        }

                        if ($remainingToSubtract > 0 && $pegawai->sisa_cuti_n1 > 0) {
                            $deduct = min($remainingToSubtract, $pegawai->sisa_cuti_n1);
                            $pegawai->sisa_cuti_n1 -= $deduct;
                            $remainingToSubtract -= $deduct;
                            $n1_used = $deduct;
                        }

                        if ($remainingToSubtract > 0 && $pegawai->sisa_cuti_n > 0) {
                            $deduct = min($remainingToSubtract, $pegawai->sisa_cuti_n);
                            $pegawai->sisa_cuti_n -= $deduct;
                            $remainingToSubtract -= $deduct;
                            $n_used = $deduct;
                        }

                        $total_akumulasi = $pegawai->sisa_cuti_n + $pegawai->sisa_cuti_n1 + $pegawai->sisa_cuti_n2;
                        $pegawai->sisa_cuti_tahunan = min(24, $total_akumulasi);

                        $form = $request->form;
                        $form['catatan_n2'] = $pegawai->sisa_cuti_n2 > 0 ? $pegawai->sisa_cuti_n2 : '';
                        $form['catatan_n1'] = $pegawai->sisa_cuti_n1 > 0 ? $pegawai->sisa_cuti_n1 : '';
                        $form['catatan_n'] = $pegawai->sisa_cuti_n > 0 ? $pegawai->sisa_cuti_n : '';
                        $form['n2_used'] = $n2_used ?? '';
                        $form['n1_used'] = $n1_used ?? '';
                        $form['n_used'] = $n_used ?? '';

                        $cuti->update(['form_data' => $form]);
                        $request->merge(['form' => $form]);
                    } else {
                        $pegawai->sisa_cuti_tahunan = max(0, $pegawai->sisa_cuti_tahunan - $lamaCuti);

                        $form = $request->form;
                        $form['catatan_n'] = $pegawai->sisa_cuti_tahunan > 0 ? $pegawai->sisa_cuti_tahunan : '';

                        $cuti->update(['form_data' => $form]);
                        $request->merge(['form' => $form]);
                    }
                    $pegawai->save();
                }
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat Izin Cuti berhasil dibuat',
                    'surat_id' => $surat->id_surat,
                    'nomor_surat' => $surat->nomor_surat,
                    'file_url' => route('template-surat.cuti.file', $surat->id_surat),
                ]);
            }

            return redirect()->route('draft-surat.cuti.index')->with('success', 'Draft Surat Izin Cuti berhasil dibuat');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan draft: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan draft: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat membuat surat izin cuti');
        }
    }



    public function destroy(TemplateSurat $template_surat)
    {
        try {
            $templateName = $template_surat->nama_template_surat;
            $allowed = ['Surat Izin Cuti PNS', 'Surat Izin Cuti PPPK', 'Surat Izin Cuti Non ASN'];

            if (!in_array($templateName, $allowed)) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Template bukan Surat Izin Cuti',
                    ], 403);
                }
                return redirect()->back()->with('error', 'Template bukan Surat Izin Cuti');
            }

            $template_surat->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat Izin Cuti berhasil dihapus',
                    'name' => $templateName,
                ]);
            }

            return redirect()->back()->with('success', 'Surat Izin Cuti berhasil dihapus');
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
        $surat = Surat::with('cuti')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $surat
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kategori' => 'required|in:PNS,PPPK,NON ASN',
                'form' => 'required|array',
                'form.tanggal_surat' => 'required|date',
                'form.nama_atasan' => 'required|string',
            ], [
                'kategori.required' => 'Kategori wajib diisi',
                'kategori.in' => 'Kategori tidak valid',
                'form.required' => 'Form wajib diisi',
                'form.tanggal_surat.required' => 'Tanggal surat wajib diisi',
                'form.nama_atasan.required' => 'Nama atasan wajib diisi',
            ]);

            $surat = Surat::findOrFail($id);
            $cuti = SuratIzinCuti::where('id_surat', $id)->firstOrFail();
            $oldForm = $cuti->form_data;

            $pegId = $request->input('form.pegawai_id') ?? $oldForm['pegawai_id'] ?? $oldForm['pegawai_id_pns'] ?? $oldForm['pegawai_id_pppk'] ?? $oldForm['pegawai_id_nonasn'];
            $pegawai = Pegawai::find($pegId);

            if ($pegawai) {
                if (($oldForm['jenis_cuti'] ?? '') === 'Cuti Tahunan') {
                    if ($cuti->kategori === 'PNS') {
                        $pegawai->sisa_cuti_n2 += (int) ($oldForm['n2_used'] ?? 0);
                        $pegawai->sisa_cuti_n1 += (int) ($oldForm['n1_used'] ?? 0);
                        $pegawai->sisa_cuti_n += (int) ($oldForm['n_used'] ?? 0);
                    } else {
                        $pegawai->sisa_cuti_tahunan += (int) ($oldForm['lama_cuti'] ?? 0);
                    }
                }

                $newJenis = $request->input('form.jenis_cuti');
                $lamaCuti = (int) $request->input('form.lama_cuti', 0);

                if ($newJenis === 'Cuti Tahunan') {
                    if ($request->kategori === 'PNS') {
                        $remainingToSubtract = $lamaCuti;
                        $n2_used = 0;
                        $n1_used = 0;
                        $n_used = 0;

                        if ($remainingToSubtract > 0 && $pegawai->sisa_cuti_n2 > 0) {
                            $deduct = min($remainingToSubtract, $pegawai->sisa_cuti_n2);
                            $pegawai->sisa_cuti_n2 -= $deduct;
                            $remainingToSubtract -= $deduct;
                            $n2_used = $deduct;
                        }
                        if ($remainingToSubtract > 0 && $pegawai->sisa_cuti_n1 > 0) {
                            $deduct = min($remainingToSubtract, $pegawai->sisa_cuti_n1);
                            $pegawai->sisa_cuti_n1 -= $deduct;
                            $remainingToSubtract -= $deduct;
                            $n1_used = $deduct;
                        }
                        if ($remainingToSubtract > 0 && $pegawai->sisa_cuti_n > 0) {
                            $deduct = min($remainingToSubtract, $pegawai->sisa_cuti_n);
                            $pegawai->sisa_cuti_n -= $deduct;
                            $remainingToSubtract -= $deduct;
                            $n_used = $deduct;
                        }

                        $total_akumulasi = $pegawai->sisa_cuti_n + $pegawai->sisa_cuti_n1 + $pegawai->sisa_cuti_n2;
                        $pegawai->sisa_cuti_tahunan = min(24, $total_akumulasi);

                        $form = $request->form;
                        $form['catatan_n2'] = $pegawai->sisa_cuti_n2 > 0 ? $pegawai->sisa_cuti_n2 : '';
                        $form['catatan_n1'] = $pegawai->sisa_cuti_n1 > 0 ? $pegawai->sisa_cuti_n1 : '';
                        $form['catatan_n'] = $pegawai->sisa_cuti_n > 0 ? $pegawai->sisa_cuti_n : '';
                        $form['n2_used'] = $n2_used;
                        $form['n1_used'] = $n1_used;
                        $form['n_used'] = $n_used;
                        $request->merge(['form' => $form]);
                    } else {
                        $pegawai->sisa_cuti_tahunan = max(0, $pegawai->sisa_cuti_tahunan - $lamaCuti);
                        $form = $request->form;
                        $form['catatan_n'] = $pegawai->sisa_cuti_tahunan > 0 ? $pegawai->sisa_cuti_tahunan : '';
                        $request->merge(['form' => $form]);
                    }
                }
                $pegawai->save();
            }

            $surat->update([
                'tanggal_dibuat' => $request->input('form.tanggal_surat'),
                'file_path' => null,
            ]);

            $cuti->update([
                'kategori' => $request->kategori,
                'form_data' => $request->form,
            ]);

            $surat->refresh();
            $surat->load('createdBy.ruangan', 'cuti');

            return response()->json([
                'success' => true,
                'message' => 'Draft Surat Izin Cuti berhasil diperbarui',
                'data' => $surat
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui draft: ' . implode(', ', $e->validator->errors()->all()),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui draft: ' . $e->getMessage()
            ], 500);
        }
    }
}
