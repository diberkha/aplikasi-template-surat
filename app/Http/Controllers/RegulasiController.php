<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regulasi;

class RegulasiController extends Controller
{
    public function index()
    {
        $regulasis = Regulasi::with(['createdBy'])->get();

        return view('master-data.regulasi.index', compact('regulasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_regulasi' => 'required|string',
        ]);

        Regulasi::create([
            'isi_regulasi' => $request->isi_regulasi,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('master-data.regulasi.index')
            ->with('success', 'Regulasi berhasil ditambahkan');
    }

    public function getRegulasiDetail($id)
    {
        $regulasi = Regulasi::with(['createdBy'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id_regulasi' => $regulasi->id_regulasi,
                'isi_regulasi' => $regulasi->isi_regulasi,
                'created_by' => $regulasi->createdBy ? $regulasi->createdBy->username : 'N/A',
                'created_at' => $regulasi->formattedCreatedAt,
                'updated_at' => $regulasi->updated_at ? $regulasi->updated_at->format('Y-m-d H:i') : 'N/A',
            ]
        ]);
    }

    public function getRegulasiForEdit($id)
    {
        $regulasi = Regulasi::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'regulasi' => [
                    'id_regulasi' => $regulasi->id_regulasi,
                    'isi_regulasi' => $regulasi->isi_regulasi,
                    'created_at' => $regulasi->created_at,
                    'updated_at' => $regulasi->updated_at,
                ]
            ]
        ]);
    }

    public function update(Request $request, $id_regulasi)
    {
        $request->validate([
            'isi_regulasi' => 'required|string',
        ]);

        $regulasi = Regulasi::findOrFail($id_regulasi);

        $regulasi->update([
            'isi_regulasi' => $request->isi_regulasi,
        ]);

        return redirect()->route('master-data.regulasi.index')
            ->with('success', 'Regulasi berhasil diperbarui');
    }

    public function destroy($id_regulasi)
    {
        $regulasi = Regulasi::findOrFail($id_regulasi);
        $regulasi->delete();

        return redirect()->route('master-data.regulasi.index')
            ->with('success', 'Regulasi berhasil dihapus');
    }

    public function getRegulasiData($id)
    {
        $regulasi = Regulasi::findOrFail($id);

        return response()->json([
            'id_regulasi' => $regulasi->id_regulasi,
            'isi_regulasi' => $regulasi->isi_regulasi,
        ]);
    }

    public function getRegulasiList()
    {
        $regulasis = Regulasi::all();

        return response()->json($regulasis->map(function($regulasi) {
            return [
                'id_regulasi' => $regulasi->id_regulasi,
                'isi_regulasi' => $regulasi->isi_regulasi,
            ];
        }));
    }
}