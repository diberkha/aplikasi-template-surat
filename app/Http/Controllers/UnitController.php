<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('nama_unit')->get();
        return view('master-data.unit.index', compact('units'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_unit' => 'required|string|max:255|unique:units,nama_unit',
            ]);

            Unit::create([
                'nama_unit' => $request->nama_unit,
            ]);

            return redirect()->route('master-data.unit.index')
                ->with('success', 'Unit berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan unit: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan unit: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan unit: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Unit $unit)
    {
        try {
            $request->validate([
                'nama_unit' => 'required|string|max:255|unique:units,nama_unit,' . $unit->id_unit . ',id_unit',
            ]);

            $unit->update([
                'nama_unit' => $request->nama_unit,
            ]);

            return redirect()->route('master-data.unit.index')
                ->with('success', 'Unit berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui unit: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui unit: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui unit: ' . $e->getMessage());
        }
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('master-data.unit.index')
            ->with('success', 'Unit berhasil dihapus');
    }


}
