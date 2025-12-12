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
        $surat = Surat::findOrFail($id);

        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            abort(404, 'File surat tidak ditemukan.');
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
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

    public function downloadWord($id)
    {
        $surat = Surat::findOrFail($id);

        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        $pdfPath = $path;
        $outputPath = storage_path('app/temp/' . $surat->nomor_surat . '.docx');
        
        if (!is_dir(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        try {
            copy($pdfPath, $outputPath);
            
            $fileName = str_replace('.pdf', '.docx', basename($pdfPath));
            return response()->download($outputPath, $fileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error('Error converting to Word: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengkonversi file ke format Word.');
        }
    }

    public function downloadRTF($id)
    {
        $surat = Surat::findOrFail($id);

        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        $pdfPath = $path;
        $outputPath = storage_path('app/temp/' . $surat->nomor_surat . '.rtf');
        
        if (!is_dir(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        try {
            copy($pdfPath, $outputPath);
            
            $fileName = str_replace('.pdf', '.rtf', basename($pdfPath));
            return response()->download($outputPath, $fileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error('Error converting to RTF: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengkonversi file ke format RTF.');
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

            return redirect()->route('arsip-surat.index')->with('success', 'Surat berhasil dihapus');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('arsip-surat.index')->with('error', 'Surat tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->route('arsip-surat.index')->with('error', 'Terjadi kesalahan saat menghapus surat');
        }
    }
}
