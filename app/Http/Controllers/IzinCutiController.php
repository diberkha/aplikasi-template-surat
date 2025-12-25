<?php
namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\SuratIzinCuti;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class IzinCutiController extends Controller
{
    public function index(Request $request)
    {
        $query = TemplateSurat::whereIn('nama_template_surat', [
            'Surat Izin Cuti PNS', 'Surat Izin Cuti PPPK', 'Surat Izin Cuti Non ASN'
        ]);

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'a-z':
                    $query->orderBy('nama_template_surat', 'asc');
                    break;
                case 'z-a':
                    $query->orderBy('nama_template_surat', 'desc');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('nama_template_surat');
            }
        } else {
            $query->orderBy('nama_template_surat');
        }

        $templates = $query->get();
        return view('template-surat.cuti.index', compact('templates'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kategori' => 'required|in:PNS,PPPK,NON ASN',
                'template_id' => 'required|exists:template_surat,id_template_surat',
                'form' => 'required|array',
                'form.tanggal_surat' => 'required|date',
            ]);

            $kategori = strtoupper($request->kategori);
            $namaPegawai = $request->input('form.nama') ?? 'DRAFT';
            $generatedNomor = 'CUTI-' . $kategori . '-' . $namaPegawai;

            $surat = Surat::create([
                'nama_surat' => 'Surat Izin Cuti',
                'nomor_surat' => $generatedNomor,
                'tanggal_dibuat' => $request->input('form.tanggal_surat'),
                'id_template_surat' => $request->template_id,
                'id_regulasi' => null,
                'created_by' => auth()->id(),
            ]);

            // Ensure uniqueness by appending ID to nomor_surat
            $uniqueNomor = $generatedNomor . '-' . str_pad($surat->id_surat, 3, '0', STR_PAD_LEFT);
            $surat->update(['nomor_surat' => $uniqueNomor]);

            $cuti = SuratIzinCuti::create([
                'id_surat' => $surat->id_surat,
                'kategori' => $request->kategori,
                'form_data' => $request->form,
            ]);

            $pdfData = [
                'kategori' => $request->kategori,
                'form' => $request->form,
                'nomor_surat' => null,
            ];

            $this->generateAndSavePDF($surat, $pdfData);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat Izin Cuti berhasil dibuat',
                    'surat_id' => $surat->id_surat,
                    'nomor_surat' => $surat->nomor_surat,
                    'file_url' => route('template-surat.cuti.file', $surat->id_surat),
                ]);
            }

            return redirect()->route('arsip-surat.index')->with('success', 'Surat Izin Cuti berhasil dibuat');
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
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat membuat surat izin cuti.');
        }
    }

    private function generateAndSavePDF($surat, $data)
    {
        $jenis = $data['kategori'] ?? 'PNS';
        $nama = $data['form']['nama'] ?? 'Dokumen';
        $fileName = "Surat Izin Cuti-{$jenis}-{$nama}.pdf";
        $filePath = 'arsip/' . $fileName;

        $view = 'template-surat.cuti.cuti-pns.pdf';
        if ($data['kategori'] === 'PPPK') $view = 'template-surat.cuti.cuti-pppk.pdf';
        if ($data['kategori'] === 'NON ASN') $view = 'template-surat.cuti.cuti-nonasn.pdf';

        $html = view($view, ['data' => $data, 'surat' => $surat])->render();
        $pdf = Pdf::loadHTML($html)
            ->setPaper([0, 0, 612, 936], 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Times New Roman',
            ]);

        if (!Storage::exists('arsip')) Storage::makeDirectory('arsip');
        Storage::put($filePath, $pdf->output());
        $surat->update(['file_path' => $filePath]);
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
                    'message' => 'Template berhasil dihapus',
                    'name' => $templateName,
                ]);
            }

            return redirect()->back()->with('success', 'Template berhasil dihapus');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus template: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus template.');
        }
    }
}
