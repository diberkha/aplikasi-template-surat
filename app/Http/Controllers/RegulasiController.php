<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regulasi;

class RegulasiController extends Controller
{
    public function index()
    {
        $regulasis = Regulasi::orderBy('id_regulasi', 'asc')->get();

        return view('master-data.regulasi.index', compact('regulasis'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'isi_regulasi' => 'required|string',
            ]);

            Regulasi::create([
                'isi_regulasi' => $request->isi_regulasi,
            ]);

            return redirect()->route('master-data.regulasi.index')
                ->with('success', 'Regulasi berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan regulasi: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan regulasi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan regulasi: ' . $e->getMessage());
        }
    }

    public function getRegulasiDetail($id)
    {
        $regulasi = Regulasi::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id_regulasi' => $regulasi->id_regulasi,
                'isi_regulasi' => $regulasi->isi_regulasi,
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
        try {
            $request->validate([
                'isi_regulasi' => 'required|string',
            ]);

            $regulasi = Regulasi::findOrFail($id_regulasi);

            $regulasi->update([
                'isi_regulasi' => $request->isi_regulasi,
            ]);

            return redirect()->route('master-data.regulasi.index')
                ->with('success', 'Regulasi berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui regulasi: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui regulasi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui regulasi: ' . $e->getMessage());
        }
    }

    public function destroy($id_regulasi)
    {
        $regulasi = Regulasi::find($id_regulasi);

        if (!$regulasi) {
            return redirect()->route('master-data.regulasi.index')
                ->with('error', 'Data regulasi tidak ditemukan atau sudah dihapus');
        }

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

        return response()->json($regulasis->map(function ($regulasi) {
            return [
                'id_regulasi' => $regulasi->id_regulasi,
                'isi_regulasi' => $regulasi->isi_regulasi,
            ];
        }));
    }
}
