<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\SKDirektur;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SKDirekturController extends Controller
{
    public function index(Request $request)
    {
        $query = TemplateSurat::where('nama_template_surat', 'Surat Keputusan Direktur');
        
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
        return view('template-surat.sk-direktur.index', compact('templates'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('store request received', ['data' => $request->all()]);
            
            $request->validate([
                'nomor_surat' => 'required|unique:surat,nomor_surat',
                'tentang' => 'required',
                'menimbang' => 'required|array|min:1',
                'menimbang.*' => 'required|string',
                'mengingat' => 'required|array|min:1',
                'mengingat.*' => 'required|string',
                'menetapkan' => 'nullable|string',
                'memutuskan' => 'required|array|min:2',
                'memutuskan.0' => 'required|string',
                'memutuskan.1' => 'required|string',
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

            $memutuskanArray = $request->memutuskan;
            $labels = ['KESATU', 'KEDUA', 'KETIGA', 'KEEMPAT', 'KELIMA', 'KEENAM'];
            $memutuskanText = '';
            foreach ($memutuskanArray as $index => $item) {
                $item = trim((string) $item);
                if ($index > 1 && $item === '') {
                    continue; 
                }
                $label = $labels[$index] ?? 'Ke-' . ($index + 1);
                $memutuskanText .= $label . "\n" . $item . "\n\n";
            }

            $mengingatArray = $request->mengingat;
            $mengingatText = '';
            foreach ($mengingatArray as $index => $item) {
                $mengingatText .= ($index + 1) . ". " . trim($item) . "\n";
            }

            $menimbangArray = $request->menimbang;
            $menimbangText = '';
            foreach ($menimbangArray as $index => $item) {
                $letter = chr(ord('a') + $index);
                $menimbangText .= $letter . '. ' . trim($item) . "\n";
            }

            $mengingatIds = is_array($request->mengingat) ? implode(',', $request->mengingat) : $request->mengingat;

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

            $pdfData = $request->all();
            $pdfData['memutuskan'] = trim($memutuskanText);
            $pdfData['mengingat'] = trim($mengingatText);
            $pdfData['menimbang'] = trim($menimbangText);
            $pdfData['tempat_surat'] = $request->tempat_dibuat;

            $this->generateAndSavePDF($surat, $pdfData);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Surat berhasil dibuat',
                    'surat_id' => $surat->id_surat,
                    'nomor_surat' => $surat->nomor_surat,
                    'tanggal_dibuat' => \Carbon\Carbon::parse($surat->tanggal_dibuat)->format('Y-m-d'),
                    'file_url' => route('template-surat.sk-direktur.file', $surat->id_surat),
                ]);
            }

            return redirect()->route('arsip-surat.index')->with('success', 'Surat berhasil dibuat');
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
                ->with('error', 'Terjadi kesalahan saat membuat surat keputusan direktur. Silakan coba lagi.');
        }
    }

    public function file($id)
    {
        $surat = Surat::with('template', 'sop')->findOrFail($id);
        $path = storage_path('app/' . $surat->file_path);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf'; 
        
        if (str_contains($templateName, 'SK Direktur') || $surat->nama_surat === 'Surat Keputusan Direktur') {
            $filename = 'SK Direktur-' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
        } elseif (str_contains($templateName, 'SOP') || $surat->nama_surat === 'Standar Operasional Prosedur (SOP)') {
            $sop = $surat->sop;
            $nomor = ($sop && $sop->nomor_dokumen) ? $sop->nomor_dokumen : $surat->nomor_surat;
            $filename = 'SOP-' . str_replace('/', '-', $nomor) . '.pdf';
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
            
            if ($template_surat->nama_template_surat !== 'Surat Keputusan Direktur') {
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

    private function generateAndSavePDF($surat, $data)
    {
        $fileName = 'SK Direktur-' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
        $filePath = 'arsip/' . $fileName;

        try {
            Log::info('PDF Generation Step 1: Starting PDF generation', [
                'surat_id' => $surat->id_surat,
                'nomor_surat' => $surat->nomor_surat,
                'fileName' => $fileName
            ]);

            Log::info('PDF Generation Step 2: Rendering view', [
                'data_keys' => array_keys($data)
            ]);
            $html = view('template-surat.sk-direktur.pdf', ['data' => $data, 'surat' => $surat])->render();
            Log::info('PDF Generation Step 3: View rendered successfully', [
                'html_length' => strlen($html)
            ]);

            Log::info('PDF Generation Step 4: Loading HTML to PDF library');
            $pdf = Pdf::loadHTML($html)
                ->setPaper([0, 0, 612, 936], 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'Times New Roman',
                ]);
            Log::info('PDF Generation Step 5: PDF loaded successfully');

            Log::info('PDF Generation Step 6: Checking arsip directory');
            if (!Storage::exists('arsip')) {
                Storage::makeDirectory('arsip');
                Log::info('PDF Generation Step 7: Created arsip directory');
            }

            Log::info('PDF Generation Step 8: Writing PDF to storage', [
                'filePath' => $filePath,
                'disk' => 'local'
            ]);
            Storage::put($filePath, $pdf->output());
            Log::info('PDF Generation Step 9: PDF written successfully');

            Log::info('PDF Generation Step 10: Updating surat record with file_path', [
                'file_path' => $filePath
            ]);
            $surat->update(['file_path' => $filePath]);
            Log::info('PDF Generation Step 11: Surat record updated successfully');

        } catch (Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage(), [
                'exception' => (string)$e,
                'surat_id' => $surat->id_surat,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
