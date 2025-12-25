<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Exception;

class TemplateSuratController extends Controller
{
    public function file($id)
    {
        $surat = Surat::with('template')->findOrFail($id);
        $path = storage_path('app/' . $surat->file_path);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf'; // Fallback
        
        if (str_contains($templateName, 'Surat Izin Cuti')) {
            $jenis = 'PNS';
            if (str_contains($templateName, 'PPPK')) $jenis = 'PPPK';
            if (str_contains($templateName, 'Non ASN')) $jenis = 'Non ASN';
            $parts = explode('-', $surat->nomor_surat);
            $nama = $parts[2] ?? 'Dokumen';
            $filename = "Surat Izin Cuti-{$jenis}-{$nama}.pdf";
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
