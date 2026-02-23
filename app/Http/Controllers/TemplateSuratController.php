<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Exception;

use Illuminate\Http\Request;

class TemplateSuratController extends Controller
{
    use \App\Traits\LazyPdfTrait;
    public function file(Request $request, $id)
    {
        $surat = Surat::with(['template', 'sop', 'skDirektur', 'cuti'])->findOrFail($id);
        
        if ($surat->is_draft) {
            $path = $this->generateTempPdf($surat);
        } else {
            $path = $this->ensurePdfExists($surat);
        }

        if (!$path || !file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        $templateName = $surat->template ? $surat->template->nama_template_surat : '';
        $filename = 'surat.pdf';

        if (str_contains($templateName, 'Surat Izin Cuti')) {
            $filename = "{$surat->nomor_surat}.pdf";
        }

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
    }
}
