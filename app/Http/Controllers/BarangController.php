<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('supplier')->withCount('units')->get();
        return view('barangs.index', compact('barangs'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('barangs.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|unique:barangs,kode_barang|max:255',
            'nama_barang' => 'required|string|max:255',
            'stock_barang' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        Barang::create($validatedData);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['supplier', 'units.lokasi']);
        return view('barangs.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $suppliers = Supplier::all();
        return view('barangs.edit', compact('barang', 'suppliers'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:255',
            'stock_barang' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $barang->update($validatedData);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus.');
    }
}
