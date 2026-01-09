<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        $jabatans = \App\Models\Jabatan::all();
        return view('master-data.pegawai.index', compact('pegawai', 'jabatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:pegawais,nip',
            'jenis_pegawai' => 'required|in:PNS,NON ASN,PPPK',
            'masa_kerja' => 'required|date',
            'sisa_cuti_n' => 'nullable|integer',
            'sisa_cuti_n1' => 'nullable|integer',
            'sisa_cuti_n2' => 'nullable|integer',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $validated['sisa_cuti_tahunan'] = ($validated['sisa_cuti_n'] ?? 0) + ($validated['sisa_cuti_n1'] ?? 0) + ($validated['sisa_cuti_n2'] ?? 0);

        Pegawai::create($validated);

        return redirect()->route('master-data.pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:pegawais,nip,' . $id,
            'jenis_pegawai' => 'required|in:PNS,NON ASN,PPPK',
            'masa_kerja' => 'required|date',
            'sisa_cuti_n' => 'nullable|integer',
            'sisa_cuti_n1' => 'nullable|integer',
            'sisa_cuti_n2' => 'nullable|integer',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $validated['sisa_cuti_tahunan'] = ($validated['sisa_cuti_n'] ?? 0) + ($validated['sisa_cuti_n1'] ?? 0) + ($validated['sisa_cuti_n2'] ?? 0);

        $pegawai->update($validated);

        return redirect()->route('master-data.pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
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
        $type = $request->get('type');
        $isAtasan = $request->get('is_atasan');
        
        $query = Pegawai::query();

        $query->where(function($q) use ($search) {
            $q->where('nama', 'LIKE', "%$search%")
              ->orWhere('nip', 'LIKE', "%$search%");
        });

        if ($type) {
            $query->where('jenis_pegawai', $type);
        }

        if ($isAtasan === 'true') {
            $query->where(function($q) {
                $q->where('jabatan', 'LIKE', '%Direktur%')
                  ->orWhere('jabatan', 'LIKE', '%Kepala%')
                  ->orWhere('jabatan', 'LIKE', '%Kepala Seksi%')
                  ->orWhere('jabatan', 'LIKE', '%Kepala Sub Bagian%')
                  ->orWhere('jabatan', 'LIKE', '%Kepala Bidang%')
                  ->orWhere('jabatan', 'LIKE', '%Kepala Bagian%');
            });
        }

        $pegawai = $query->limit(10)->get(['id', 'nama', 'nip', 'jabatan', 'jenis_pegawai']);

        return response()->json($pegawai);
    }

    public function getDetail($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        $joinDate = Carbon::parse($pegawai->masa_kerja);
        $now = Carbon::now();
        
        $years = $joinDate->diffInYears($now);
        $months = $joinDate->diffInMonths($now) % 12;

        return response()->json([
            'id' => $pegawai->id,
            'nama' => $pegawai->nama,
            'nip' => $pegawai->nip,
            'jenis_pegawai' => $pegawai->jenis_pegawai,
            'masa_kerja' => $pegawai->masa_kerja,
            'masa_kerja_tahun' => $years,
            'masa_kerja_bulan' => $months,
            'sisa_cuti_tahunan' => $pegawai->sisa_cuti_tahunan,
            'sisa_cuti_n' => $pegawai->sisa_cuti_n,
            'sisa_cuti_n1' => $pegawai->sisa_cuti_n1,
            'sisa_cuti_n2' => $pegawai->sisa_cuti_n2,
            'jabatan' => $pegawai->jabatan,
        ]);
    }
}
