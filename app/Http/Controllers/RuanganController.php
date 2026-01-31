<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        return view('master-data.ruangan.index', compact('ruangan'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
            ]);

            Ruangan::create([
                'nama_ruangan' => $request->nama_ruangan,
            ]);

            return redirect()->route('master-data.ruangan.index')
                ->with('success', 'Ruangan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan ruangan: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan ruangan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan ruangan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        try {
            $request->validate([
                'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $request->id_ruangan . ',id_ruangan',
            ]);

            $ruangan->update([
                'nama_ruangan' => $request->nama_ruangan,
            ]);

            return redirect()->route('master-data.ruangan.index')
                ->with('success', 'Ruangan berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui ruangan: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui ruangan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui ruangan: ' . $e->getMessage());
        }
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()->route('master-data.ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus');
    }
}
