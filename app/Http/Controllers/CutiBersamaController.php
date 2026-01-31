<?php

namespace App\Http\Controllers;

use App\Models\CutiBersama;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CutiBersamaController extends Controller
{
    public function index()
    {
        $cutisBersama = CutiBersama::orderBy('tahun', 'desc')->orderBy('id', 'desc')->get();
        return view('cuti-bersama.index', compact('cutisBersama'));
    }

    public function create()
    {
        return view('cuti-bersama.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'jenis_cuti_bersama' => 'required|string|max:255',
                'tahun' => 'required|integer|min:2000|max:2100',
                'jumlah_hari' => 'required|integer|min:1',
                'is_perhitungan_cuti_tahunan' => 'sometimes|boolean',
                'catatan' => 'nullable|string',
            ]);

            $validated['is_perhitungan_cuti_tahunan'] = $request->has('is_perhitungan_cuti_tahunan');

            DB::transaction(function () use ($validated) {
                $cutiBersama = CutiBersama::create($validated);

                if ($cutiBersama->is_perhitungan_cuti_tahunan) {
                    foreach (Pegawai::all() as $pegawai) {
                        $pegawai->adjustLeaveBalance(-$cutiBersama->jumlah_hari);
                    }
                }
            });

            return redirect()->route('cuti-bersama.index')
                ->with('success', 'Cuti bersama berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan cuti bersama: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan cuti bersama: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan cuti bersama: ' . $e->getMessage());
        }
    }

    public function edit(CutiBersama $cutiBersama)
    {
        return view('cuti-bersama.edit', compact('cutiBersama'));
    }

    public function update(Request $request, CutiBersama $cutiBersama)
    {
        try {
            $validated = $request->validate([
                'jenis_cuti_bersama' => 'required|string|max:255',
                'tahun' => 'required|integer|min:2000|max:2100',
                'jumlah_hari' => 'required|integer|min:1',
                'is_perhitungan_cuti_tahunan' => 'sometimes|boolean',
                'catatan' => 'nullable|string',
            ]);

            $validated['is_perhitungan_cuti_tahunan'] = $request->has('is_perhitungan_cuti_tahunan');

            DB::transaction(function () use ($validated, $cutiBersama) {
                if ($cutiBersama->is_perhitungan_cuti_tahunan) {
                    foreach (Pegawai::all() as $pegawai) {
                        $pegawai->adjustLeaveBalance((int) ($cutiBersama->jumlah_hari ?? 0));
                    }
                }

                $cutiBersama->update($validated);

                if ($cutiBersama->is_perhitungan_cuti_tahunan) {
                    foreach (Pegawai::all() as $pegawai) {
                        $pegawai->adjustLeaveBalance(-(int) ($cutiBersama->jumlah_hari ?? 0));
                    }
                }
            });

            return redirect()->route('cuti-bersama.index')
                ->with('success', 'Cuti bersama berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui cuti bersama: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui cuti bersama: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui cuti bersama: ' . $e->getMessage());
        }
    }

    public function destroy(CutiBersama $cutiBersama)
    {
        DB::transaction(function () use ($cutiBersama) {
            if ($cutiBersama->is_perhitungan_cuti_tahunan) {
                foreach (Pegawai::all() as $pegawai) {
                    $pegawai->adjustLeaveBalance((int) ($cutiBersama->jumlah_hari ?? 0));
                }
            }
            $cutiBersama->delete();
        });

        return redirect()->route('cuti-bersama.index')
            ->with('success', 'Cuti bersama berhasil dihapus');
    }
}
