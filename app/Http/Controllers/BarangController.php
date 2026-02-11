<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Kelas;
use App\Models\Lab;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with(['supplier', 'lokasi'])->get();
        return view('barangs.index', compact('barangs'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $kelas = Kelas::all();
        $labs = Lab::all();
        return view('barangs.create', compact('suppliers', 'kelas', 'labs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|unique:barangs,kode_barang|max:255',
            'nama_barang' => 'required|string|max:255',
            'stock_barang' => 'required|integer|min:0',
            'detail_barang' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'lokasi_id' => 'required',
            'lokasi_type' => 'required|in:kelas,lab',
        ]);

        // Adjust lokasi_type to full class name
        if ($validatedData['lokasi_type'] === 'kelas') {
            $validatedData['lokasi_type'] = Kelas::class;
        }
        else {
            $validatedData['lokasi_type'] = Lab::class;
        }

        Barang::create($validatedData);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $suppliers = Supplier::all();
        $kelas = Kelas::all();
        $labs = Lab::all();
        return view('barangs.edit', compact('barang', 'suppliers', 'kelas', 'labs'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:255',
            'stock_barang' => 'required|integer|min:0',
            'detail_barang' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'lokasi_id' => 'required',
            'lokasi_type' => 'required|in:kelas,lab',
        ]);

        // Adjust lokasi_type to full class name
        if ($validatedData['lokasi_type'] === 'kelas') {
            $validatedData['lokasi_type'] = Kelas::class;
        }
        else {
            $validatedData['lokasi_type'] = Lab::class;
        }

        $barang->update($validatedData);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus.');
    }
}
