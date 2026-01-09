<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
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
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('master-data.jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->all());

        return redirect()->route('master-data.jabatan.index')
            ->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('master-data.jabatan.index')
            ->with('success', 'Jabatan berhasil dihapus');
    }
}
