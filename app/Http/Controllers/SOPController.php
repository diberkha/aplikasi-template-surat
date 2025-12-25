<?php

namespace App\Http\Controllers;

use App\Models\SOP;
use App\Models\Surat;
use App\Models\TemplateSurat;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SOPController extends Controller
{
    public function index(Request $request)
    {
        $query = TemplateSurat::where('nama_template_surat', 'like', '%SOP%');

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
        return view('template-surat.sop.index', compact('templates'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul_sop' => 'required|string',
                'nomor_dokumen' => 'required|string',
                'nomor_revisi' => 'required|string',
                'halaman' => 'nullable|string',
                'tanggal_terbit' => 'required|date',
                'pengertian' => 'required|string',
                'tujuan' => 'required|string',
                'kebijakan' => 'required|array|min:1',
                'kebijakan.*' => 'required|string',
                'prosedur' => 'required|array|min:1',
                'prosedur.*' => 'required|string',
                'unit_terkait' => 'required|string',
                'template_id' => 'required|exists:template_surat,id_template_surat',
            ]);

            $surat = Surat::create([
                'nama_surat' => 'Standar Operasional Prosedur (SOP)',
                'nomor_surat' => 'SOP-' . uniqid(),
                'tanggal_dibuat' => $request->tanggal_terbit,
                'id_template_surat' => $request->template_id,
                'id_regulasi' => null,
                'created_by' => auth()->id(),
            ]);

            $kebijakanText = implode("\n", array_filter($request->kebijakan));
            $prosedurText = implode("\n", array_filter($request->prosedur));

            SOP::create([
                'id_surat' => $surat->id_surat,
                'judul_sop' => $request->judul_sop,
                'nomor_dokumen' => $request->nomor_dokumen,
                'nomor_revisi' => $request->nomor_revisi,
                'halaman' => $request->filled('halaman') ? $request->halaman : '1/1',
                'tanggal_terbit' => $request->tanggal_terbit,
                'pengertian' => $request->pengertian,
                'tujuan' => $request->tujuan,
                'kebijakan' => $kebijakanText,
                'prosedur' => $prosedurText,
                'unit_terkait' => $request->unit_terkait,
            ]);

            $pdfData = $request->all();
            $pdfData['halaman'] = $request->filled('halaman') ? $request->halaman : '1/1';

            $this->generateAndSavePDF($surat, $pdfData);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Standar Operasional Prosedur (SOP) berhasil dibuat',
                    'surat_id' => $surat->id_surat,
                    'nomor_surat' => $request->nomor_dokumen,
                    'tanggal_dibuat' => \Carbon\Carbon::parse($surat->tanggal_dibuat)->format('Y-m-d'),
                    'judul_sop' => $request->judul_sop,
                    'file_url' => route('template-surat.sk-direktur.file', $surat->id_surat),
                ]);
            }

            return redirect()->route('arsip-surat.index')->with('success', 'Standar Operasional Prosedur (SOP) berhasil dibuat');
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
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat membuat Standar Operasional Prosedur (SOP).');
        }
    }

    public function destroy(TemplateSurat $template_surat)
    {
        try {
            $templateName = $template_surat->nama_template_surat;
            
            if (stripos($template_surat->nama_template_surat, 'SOP') === false) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Template bukan Standar Operasional Prosedur (SOP)',
                    ], 403);
                }
                return redirect()->back()->with('error', 'Template bukan Standar Operasional Prosedur (SOP)');
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
        $nomor = $data['nomor_dokumen'] ?? $surat->nomor_surat;
        $fileName = 'SOP-' . str_replace('/', '-', $nomor) . '.pdf';
        $filePath = 'arsip/' . $fileName;

        try {
            $html = view('template-surat.sop.pdf', ['data' => $data, 'surat' => $surat])->render();
            $pdf = Pdf::loadHTML($html)
                ->setPaper([0, 0, 612, 936], 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'Times New Roman',
                ]);

            if (!Storage::exists('arsip')) {
                Storage::makeDirectory('arsip');
            }
            Storage::put($filePath, $pdf->output());
            $surat->update(['file_path' => $filePath]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}

