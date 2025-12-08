<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArsipSuratController extends Controller
{
    public function index(Request $request)
    {
        $templateOptions = TemplateSurat::select('id_template_surat', 'nama_template_surat')
            ->orderBy('nama_template_surat')
            ->get();

        if (Surat::count() === 0) {
            return $this->showDummyData($request, $templateOptions);
        }

        $query = Surat::with(['template', 'createdBy', 'skDirektur'])
            ->orderBy('tanggal_dibuat', 'desc');

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

    private function showDummyData(Request $request, $templateOptions = null)
    {
        $dummySurat = collect([
            [
                'id_surat' => 1,
                'nama_surat' => 'Surat Keputusan Direktur',
                'nomor_surat' => '006/SHKS/VI/2024',
                'tipe_surat' => 'Surat Hukum & Kerja Sama',
                'tanggal_dibuat' => '2024-06-10',
                'created_by' => 'Manager',
                'username' => 'Manager',
                'created_at' => '2024-06-10 14:20:00',
                'updated_at' => '2024-06-10 14:20:00',
            ],
        ]);

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $dummySurat = $dummySurat->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['nama_surat']), $search) ||
                    str_contains(strtolower($item['nomor_surat']), $search) ||
                    str_contains(strtolower($item['tipe_surat']), $search) ||
                    str_contains(strtolower($item['username']), $search);
            });
        }

        if ($request->filled('template') && $templateOptions) {
            $selected = $templateOptions->firstWhere('id_template_surat', $request->template);
            if ($selected) {
                $dummySurat = $dummySurat->where('tipe_surat', $selected->nama_template_surat);
            }
        }

        if ($request->filled('start_date')) {
            $dummySurat = $dummySurat->filter(function ($item) use ($request) {
                return Carbon::parse($item['tanggal_dibuat'])->greaterThanOrEqualTo($request->start_date);
            });
        }

        if ($request->filled('end_date')) {
            $dummySurat = $dummySurat->filter(function ($item) use ($request) {
                return Carbon::parse($item['tanggal_dibuat'])->lessThanOrEqualTo($request->end_date);
            });
        }

        $surat = $dummySurat;
        $totalSurat = $dummySurat->count();

        if (!$templateOptions || $templateOptions->isEmpty()) {
            $templateOptions = collect([
                (object) ['id_template_surat' => 1, 'nama_template_surat' => 'Surat Hukum & Kerja Sama'],
            ]);
        }

        return view('arsip-surat.index', compact('surat', 'totalSurat', 'templateOptions'));
    }

    public function show($id)
    {
        if (Surat::count() === 0) {
            $dummy = collect([
                [
                    'id_surat' => 2,
                    'nama_surat' => 'Surat Keputusan Direktur',
                    'nomor_surat' => '006/SHKS/VI/2024',
                    'tipe_surat' => 'Surat Hukum & Kerja Sama',
                    'tanggal_dibuat' => '2024-06-10',
                    'created_by' => 'Manager',
                    'username' => 'Manager',
                    'created_at' => '2024-06-10 14:20:00',
                    'updated_at' => '2024-06-10 14:20:00',
                ],
            ]);

            $surat = $dummy->firstWhere('id_surat', (int) $id);
            if (!$surat) {
                abort(404, 'Surat tidak ditemukan.');
            }

            return view('arsip-surat.show', ['surat' => (object) $surat]);
        }

        $surat = Surat::with(['template', 'createdBy'])->findOrFail($id);
        return view('arsip-surat.show', compact('surat'));
    }

    public function download($id)
    {
        $surat = Surat::findOrFail($id);

        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        return response()->download($path);
    }

    public function edit($id)
    {
        $surat = Surat::with(['skDirektur', 'template'])->findOrFail($id);
        
        // Return JSON for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'surat' => $surat
            ]);
        }
        
        return view('arsip-surat.edit', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        try {
            $surat = Surat::with('skDirektur')->findOrFail($id);
            
            // Validate input
            $validated = $request->validate([
                'judul_surat' => 'required|string',
                'nomor_surat' => 'required|unique:surat,nomor_surat,' . $id . ',id_surat',
                'tentang' => 'required',
                'identitas_penetap' => 'required',
                'menimbang' => 'required',
                'mengingat' => 'required',
                'memutuskan' => 'required|array|min:1',
                'memutuskan.*' => 'required|string',
                'tempat_dibuat' => 'required',
                'tanggal_dibuat' => 'required|date',
                'jabatan_pembuat' => 'required',
                'nama_pembuat' => 'required',
            ]);

            // Format memutuskan array to string
            $memutuskanArray = $request->memutuskan;
            $labels = ['KESATU', 'KEDUA', 'KETIGA', 'KEEMPAT', 'KELIMA', 'KEENAM', 'KETUJUH', 'KEDELAPAN', 'KESEMBILAN', 'KESEPULUH'];
            $memutuskanText = '';
            
            foreach ($memutuskanArray as $index => $item) {
                $label = $labels[$index] ?? 'KE-' . ($index + 1);
                $memutuskanText .= $label . "\n" . trim($item) . "\n\n";
            }

            // Update Surat
            $surat->update([
                'nama_surat' => $request->judul_surat,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
            ]);

            // Update SKDirektur
            if ($surat->skDirektur) {
                $surat->skDirektur->update([
                    'judul_surat' => $request->judul_surat,
                    'nomor_surat' => $request->nomor_surat,
                    'tentang' => $request->tentang,
                    'identitas_penetap' => $request->identitas_penetap,
                    'menimbang' => $request->menimbang,
                    'mengingat' => $request->mengingat,
                    'memutuskan' => trim($memutuskanText),
                    'tempat_dibuat' => $request->tempat_dibuat,
                    'tanggal_dibuat' => $request->tanggal_dibuat,
                    'jabatan_pembuat' => $request->jabatan_pembuat,
                    'nama_pembuat' => $request->nama_pembuat,
                ]);
            }

            // Return JSON for AJAX requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat berhasil diupdate',
                    'surat' => $surat
                ]);
            }

            return redirect()->route('arsip-surat.index')->with('success', 'Surat berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Error updating surat: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ], 500);
            }
            
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengupdate surat');
        }
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

            return redirect()->route('arsip-surat.index')->with('success', 'Surat berhasil dihapus dari arsip.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('arsip-surat.index')->with('error', 'Surat tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('arsip-surat.index')->with('error', 'Terjadi kesalahan saat menghapus surat.');
        }
    }
}
