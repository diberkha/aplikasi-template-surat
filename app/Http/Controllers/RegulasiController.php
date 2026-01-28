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
}

