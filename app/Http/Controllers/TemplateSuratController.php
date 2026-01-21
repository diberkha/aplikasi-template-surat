<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Exception;

class TemplateSuratController extends Controller
{
    use \App\Traits\LazyPdfTrait;
    public function file($id)
    {
        $surat = Surat::with(['template', 'sop', 'skDirektur', 'cuti'])->findOrFail($id);
        $path = $this->ensurePdfExists($surat);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf';

        if (str_contains($templateName, 'Surat Izin Cuti')) {
            $filename = "{$surat->nomor_surat}.pdf";
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
