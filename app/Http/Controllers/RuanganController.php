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
        $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
        ]);

        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
        ]);

        return redirect()->route('master-data.ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $ruangan->id_ruangan . ',id_ruangan',
        ]);

        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan,
        ]);

        return redirect()->route('master-data.ruangan.index')
            ->with('success', 'Ruangan berhasil diperbarui');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()->route('master-data.ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus');
    }
}
