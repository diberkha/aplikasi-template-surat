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
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:units,nama_unit',
        ]);

        Unit::create([
            'nama_unit' => $request->nama_unit,
        ]);

        return redirect()->route('master-data.unit.index')
            ->with('success', 'Unit berhasil ditambahkan');
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:units,nama_unit,' . $unit->id_unit . ',id_unit',
        ]);

        $unit->update([
            'nama_unit' => $request->nama_unit,
        ]);

        return redirect()->route('master-data.unit.index')
            ->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('master-data.unit.index')
            ->with('success', 'Unit berhasil dihapus');
    }

    public function getUnitList()
    {
        $units = Unit::orderBy('nama_unit')->get();
        return response()->json([
            'success' => true,
            'data' => $units
        ]);
    }
}
