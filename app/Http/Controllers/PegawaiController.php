<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::orderBy('nama')->get();
        return view('master-data.pegawai.index', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:pegawais,nip',
            'tanggal_masuk' => 'required|date',
        ]);

        Pegawai::create($validated);

        return redirect()->route('master-data.pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:pegawais,nip,' . $id,
            'tanggal_masuk' => 'required|date',
        ]);

        $pegawai->update($validated);

        return redirect()->route('master-data.pegawai.index')->with('success', 'Pegawai berhasil diupdate');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('master-data.pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }

    public function search(Request $request)
    {
        $search = $request->get('term');
        
        $pegawai = Pegawai::where('nama', 'LIKE', "%$search%")
            ->orWhere('nip', 'LIKE', "%$search%")
            ->limit(10)
            ->get(['id', 'nama', 'nip']);

        return response()->json($pegawai);
    }

    public function getDetail($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        $joinDate = Carbon::parse($pegawai->tanggal_masuk);
        $now = Carbon::now();
        
        $years = $joinDate->diffInYears($now);
        $months = $joinDate->diffInMonths($now) % 12;

        return response()->json([
            'id' => $pegawai->id,
            'nama' => $pegawai->nama,
            'nip' => $pegawai->nip,
            'tanggal_masuk' => $pegawai->tanggal_masuk,
            'masa_kerja_tahun' => $years,
            'masa_kerja_bulan' => $months,
            'sisa_cuti_tahunan' => $pegawai->sisa_cuti_tahunan,
        ]);
    }
}
