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

class TemplateSuratController extends Controller
{
    public function suratHukum(Request $request)
    {
        $query = TemplateSurat::where('nama_template_surat', 'like', '%Hukum%');

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
        return view('template-surat.surat-hukum.index', compact('templates'));
    }

    public function storeSuratHukum(Request $request)
    {
        try {
            $request->validate([
                'nama_surat' => 'nullable|string',
                'nomor_surat' => 'required|unique:surat,nomor_surat',
                'tanggal_dibuat' => 'required|date',
                'judul_surat' => 'required|string',
                'tentang' => 'required',
                'identitas_penetap' => 'required',
                'menimbang' => 'required',
                'mengingat' => 'required',
                'memutuskan' => 'required',
                'menetapkan' => 'nullable',
                'id_surat' => 'nullable|exists:surat,id_surat',
                'tempat_dibuat' => 'required',
                'template_id' => 'required|exists:template_surat,id_template_surat',
            ]);

            $namaSurat = $request->input('nama_surat') ?? $request->input('judul_surat') ?? 'Surat Baru';

            $surat = Surat::create([
                'nama_surat' => $namaSurat,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'id_template_surat' => $request->template_id,
                'created_by' => auth()->id(),
            ]);

            Log::info('Surat created', ['id' => $surat->id_surat, 'surat' => $surat->toArray()]);

            SKDirektur::create([
                'judul_surat' => $request->judul_surat,
                'nomor_surat' => $request->nomor_surat,
                'tentang' => $request->tentang,
                'identitas_penetap' => $request->identitas_penetap,
                'menimbang' => $request->menimbang,
                'mengingat' => $request->mengingat,
                'memutuskan' => $request->memutuskan,
                'menetapkan' => $request->menetapkan ?? null,
                'tempat_dibuat' => $request->tempat_dibuat,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'id_surat' => $surat->id_surat,
            ]);

            $this->generateAndSavePDF($surat, $request->all());

            return redirect()->route('arsip-surat.index')
                ->with('success', 'Surat hukum berhasil dibuat dan disimpan di arsip.');
        } catch (ValidationException $e) {
            Log::warning('Validation failed for storeSuratHukum', [
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (Exception $e) {
            if (method_exists($e, 'errors')) {
                Log::warning('Validation-like exception in storeSuratHukum', [
                    'errors' => $e->errors(),
                    'message' => $e->getMessage(),
                    'input' => $request->all(),
                ]);
            } else {
                Log::error('Error creating Surat Hukum: ' . $e->getMessage(), [
                    'exception' => $e,
                    'input' => $request->all(),
                ]);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat surat hukum. Silakan coba lagi.');
        }
    }

    private function generateAndSavePDF($surat, $data)
    {
        $fileName = 'surat-' . str_replace('/', '-', $surat->nomor_surat) . '-' . time() . '.pdf';
        $filePath = 'arsip/' . $fileName;

        try {
            $html = view('template-surat.surat-hukum.pdf', ['data' => $data, 'surat' => $surat])->render();
            $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');

            if (!Storage::exists('arsip')) {
                Storage::makeDirectory('arsip');
            }

            Storage::put($filePath, $pdf->output());

            $surat->update(['file_path' => $filePath]);
        } catch (\Exception $e) {
        }
    }

    public function preview($id)
    {
        $surat = Surat::findOrFail($id);

        if (!$surat->file_path || !Storage::exists($surat->file_path)) {
            return redirect()->back()->with('error', 'File belum tersedia.');
        }

        $fileUrl = route('template-surat.hukum.file', $surat->id_surat);
        return view('template-surat.surat-hukum.preview', compact('surat', 'fileUrl'));
    }

    public function file($id)
    {
        $surat = Surat::findOrFail($id);
        $path = storage_path('app/' . $surat->file_path);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        return response()->file($path);
    }
}