<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Exception;

class TemplateSuratController extends Controller
{
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
