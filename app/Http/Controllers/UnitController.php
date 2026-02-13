<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Barang;
use App\Models\Kelas;
use App\Models\Lab;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with(['barang', 'lokasi'])->get();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        $barangs = Barang::all();
        $kelas = Kelas::all();
        $labs = Lab::all();
        return view('units.create', compact('barangs', 'kelas', 'labs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'kode_unit' => 'required|string|unique:units,kode_unit|max:255',
            'lokasi_id' => 'required',
            'lokasi_type' => 'required|in:kelas,lab',
            'kondisi' => 'required|in:baik,rusak,hilang',
            'detail_unit' => 'nullable|string',
        ]);

        if ($validatedData['lokasi_type'] === 'kelas') {
            $validatedData['lokasi_type'] = Kelas::class;
        }
        else {
            $validatedData['lokasi_type'] = Lab::class;
        }

        Unit::create($validatedData);

        if ($request->filled('redirect_to')) {
            return redirect($request->redirect_to)->with('success', 'Unit berhasil ditambahkan.');
        }

        return redirect()->route('units.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function edit(Unit $unit)
    {
        $barangs = Barang::all();
        $kelas = Kelas::all();
        $labs = Lab::all();
        return view('units.edit', compact('unit', 'barangs', 'kelas', 'labs'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'kode_unit' => 'required|string|max:255|unique:units,kode_unit,' . $unit->id,
            'lokasi_id' => 'required',
            'lokasi_type' => 'required|in:kelas,lab',
            'kondisi' => 'required|in:baik,rusak,hilang',
            'detail_unit' => 'nullable|string',
        ]);

        if ($validatedData['lokasi_type'] === 'kelas') {
            $validatedData['lokasi_type'] = Kelas::class;
        }
        else {
            $validatedData['lokasi_type'] = Lab::class;
        }

        $unit->update($validatedData);

        return redirect()->route('units.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('units.index')->with('success', 'Unit berhasil dihapus.');
    }
}
