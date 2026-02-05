<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('master-data.jabatan.index', compact('jabatans'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_jabatan' => 'required|string|max:255',
            ]);

            Jabatan::create($request->all());

            return redirect()->route('master-data.jabatan.index')
                ->with('success', 'Jabatan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan jabatan: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan jabatan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan jabatan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_jabatan' => 'required|string|max:255',
            ]);

            $jabatan = Jabatan::findOrFail($id);
            $oldNama = $jabatan->nama_jabatan;

            $jabatan->update($request->all());

            if ($oldNama !== $request->nama_jabatan) {
                Pegawai::where('jabatan', $oldNama)->update(['jabatan' => $request->nama_jabatan]);
            }

            return redirect()->route('master-data.jabatan.index')
                ->with('success', 'Jabatan berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui jabatan: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui jabatan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui jabatan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('master-data.jabatan.index')
            ->with('success', 'Jabatan berhasil dihapus');
    }
}
