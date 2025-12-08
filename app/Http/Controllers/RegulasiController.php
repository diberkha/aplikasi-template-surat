<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regulasi;
use App\Models\TemplateSurat;
use App\Models\Surat;
use App\Models\Keputusan;

class RegulasiController extends Controller
{
    public function index()
    {
        $regulasis = Regulasi::with(['template', 'surat', 'keputusan', 'createdBy'])->get();

        $templates = TemplateSurat::all();
        $surats = Surat::all();
        $keputusans = Keputusan::all();

        return view('regulasi.index', compact('regulasis', 'templates', 'surats', 'keputusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_template_surat' => 'required|exists:template_surat,id_template_surat',
            'id_surat' => 'required|exists:surat,id_surat',
            'id_keputusan' => 'nullable|exists:keputusan,id_keputusan',
            'keputusan_lainnya' => 'nullable|string',
            'menimbang' => 'required|string',
            'mengingat' => 'required|string',
        ]);

        Regulasi::create([
            'id_template_surat' => $request->id_template_surat,
            'id_surat' => $request->id_surat,
            'id_keputusan' => $request->id_keputusan,
            'keputusan_lainnya' => $request->keputusan_lainnya,
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
        $regulasi = Regulasi::with(['template', 'surat', 'keputusan', 'createdBy'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id_regulasi' => $regulasi->id_regulasi,
                'nama_surat' => $regulasi->surat ? $regulasi->surat->nama_surat : 'N/A',
                'tipe_surat' => $regulasi->template ? $regulasi->template->nama_template_surat : 'Tidak ada tipe surat',
                'keputusan' => $regulasi->keputusan ? $regulasi->keputusan->nama_keputusan : ($regulasi->keputusan_lainnya ?? 'N/A'),
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
        $regulasi = Regulasi::with(['template', 'surat', 'keputusan'])->findOrFail($id);

        $surats = Surat::where('id_template_surat', $regulasi->id_template_surat)->get();
        $keputusans = Keputusan::all();

        return response()->json([
            'success' => true,
            'data' => [
                'regulasi' => [
                    'id_regulasi' => $regulasi->id_regulasi,
                    'id_template_surat' => $regulasi->id_template_surat,
                    'id_surat' => $regulasi->id_surat,
                    'id_keputusan' => $regulasi->id_keputusan,
                    'keputusan_lainnya' => $regulasi->keputusan_lainnya,
                    'menimbang' => $regulasi->menimbang,
                    'mengingat' => $regulasi->mengingat,
                    'created_at' => $regulasi->created_at,
                    'updated_at' => $regulasi->updated_at,
                ],
                'surats' => $surats,
                'keputusans' => $keputusans
            ]
        ]);
    }

    public function update(Request $request, $id_regulasi)
    {
        $request->validate([
            'id_template_surat' => 'required|exists:template_surat,id_template_surat',
            'id_surat' => 'required|exists:surat,id_surat',
            'id_keputusan' => 'nullable|exists:keputusan,id_keputusan',
            'keputusan_lainnya' => 'nullable|string',
            'menimbang' => 'required|string',
            'mengingat' => 'required|string',
        ]);

        $regulasi = Regulasi::findOrFail($id_regulasi);

        $regulasi->update([
            'id_template_surat' => $request->id_template_surat,
            'id_surat' => $request->id_surat,
            'id_keputusan' => $request->id_keputusan,
            'keputusan_lainnya' => $request->keputusan_lainnya,
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

    public function getKeputusanList()
    {
        $regulasis = Regulasi::with(['keputusan', 'surat'])->get()->map(function($regulasi) {
            $keputusanLabel = $regulasi->keputusan 
                ? $regulasi->keputusan->nama_keputusan 
                : ($regulasi->keputusan_lainnya ?? 'Keputusan Tidak Diketahui');
            
            $suratLabel = $regulasi->surat ? $regulasi->surat->nama_surat : 'Surat Tidak Diketahui';
            
            return [
                'id_regulasi' => $regulasi->id_regulasi,
                'keputusan_label' => $keputusanLabel . ' - ' . $suratLabel,
                'id_template_surat' => $regulasi->id_template_surat,
            ];
        });

        return response()->json($regulasis);
    }

    public function getRegulasiData($id)
    {
        $regulasi = Regulasi::findOrFail($id); 
        
        // Parse isi_regulasi JSON
        $isiRegulasiArray = is_array($regulasi->isi_regulasi) 
            ? $regulasi->isi_regulasi 
            : json_decode($regulasi->isi_regulasi, true);

        return response()->json([
            'id_regulasi' => $regulasi->id_regulasi,
            'id_template_surat' => $regulasi->id_template_surat,
            'id_surat' => $regulasi->id_surat,
            'menimbang' => $isiRegulasiArray['menimbang'] ?? '',
            'mengingat' => $isiRegulasiArray['mengingat'] ?? '',
        ]);
    }

    private function getBadgeColor($templateName)
    {
        $colors = [
            'Surat Hukum & Kerja Sama' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        ];

        return $colors[$templateName] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
    }
}