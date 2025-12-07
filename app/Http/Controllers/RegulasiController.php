<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regulasi;
use App\Models\TemplateSurat;
use App\Models\Surat;

class RegulasiController extends Controller
{
    public function index()
    {
        $regulasis = Regulasi::with(['template', 'surat', 'createdBy'])->get();

        $templates = TemplateSurat::all();
        $surats = Surat::all();

        return view('regulasi.index', compact('regulasis', 'templates', 'surats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_template_surat' => 'required|exists:template_surat,id_template_surat',
            'id_surat' => 'required|exists:surat,id_surat',
            'menimbang' => 'required|string',
            'mengingat' => 'required|string',
        ]);

        Regulasi::create([
            'id_template_surat' => $request->id_template_surat,
            'id_surat' => $request->id_surat,
            'isi_regulasi' => [
                'menimbang' => $request->menimbang,
                'mengingat' => $request->mengingat,
            ],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('regulasi.index')
            ->with('success', 'Regulasi berhasil ditambahkan');
    }

    public function getSuratByTemplate($templateId)
    {
        $surats = Surat::where('id_template_surat', $templateId)->get();

        return response()->json($surats);
    }

    public function getRegulasiDetail($id)
    {
        $regulasi = Regulasi::with(['template', 'surat', 'createdBy'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id_regulasi' => $regulasi->id_regulasi,
                'nama_surat' => $regulasi->surat ? $regulasi->surat->nama_surat : 'N/A',
                'tipe_surat' => $regulasi->template ? $regulasi->template->nama_template_surat : 'Tidak ada tipe surat',
                'created_by' => $regulasi->createdBy ? $regulasi->createdBy->username : 'N/A',
                'created_at' => $regulasi->formattedCreatedAt,
                'updated_at' => $regulasi->updated_at ? $regulasi->updated_at->format('Y-m-d H:i') : 'N/A',
                'menimbang' => $regulasi->menimbang,
                'mengingat' => $regulasi->mengingat,
                'badge_color' => $this->getBadgeColor($regulasi->template->nama_template_surat ?? '')
            ]
        ]);
    }

    public function getRegulasiForEdit($id)
    {
        $regulasi = Regulasi::with(['template', 'surat'])->findOrFail($id);

        $surats = Surat::where('id_template_surat', $regulasi->id_template_surat)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'regulasi' => [
                    'id_regulasi' => $regulasi->id_regulasi,
                    'id_template_surat' => $regulasi->id_template_surat,
                    'id_surat' => $regulasi->id_surat,
                    'menimbang' => $regulasi->menimbang,
                    'mengingat' => $regulasi->mengingat,
                    'created_at' => $regulasi->created_at,
                    'updated_at' => $regulasi->updated_at,
                ],
                'surats' => $surats
            ]
        ]);
    }

    public function update(Request $request, $id_regulasi)
    {
        $request->validate([
            'id_template_surat' => 'required|exists:template_surat,id_template_surat',
            'id_surat' => 'required|exists:surat,id_surat',
            'menimbang' => 'required|string',
            'mengingat' => 'required|string',
        ]);

        $regulasi = Regulasi::findOrFail($id_regulasi);

        $regulasi->update([
            'id_template_surat' => $request->id_template_surat,
            'id_surat' => $request->id_surat,
            'isi_regulasi' => [
                'menimbang' => $request->menimbang,
                'mengingat' => $request->mengingat,
            ],
        ]);

        return redirect()->route('regulasi.index')
            ->with('success', 'Regulasi berhasil diperbarui');
    }

    public function destroy($id_regulasi)
    {
        $regulasi = Regulasi::findOrFail($id_regulasi);
        $regulasi->delete();

        return redirect()->route('regulasi.index')
            ->with('success', 'Regulasi berhasil dihapus');
    }

    private function getBadgeColor($templateName)
    {
        $colors = [
            'Surat Hukum & Kerja Sama' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        ];

        return $colors[$templateName] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
    }
}