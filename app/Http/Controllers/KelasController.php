<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = \App\Models\Kelas::with('jurusan')->get();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusans = \App\Models\Jurusan::all();
        return view('kelas.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|string|max:10',
        ]);

        \App\Models\Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(\App\Models\Kelas $kelas)
    {
        return view('kelas.show', compact('kelas'));
    }

    public function edit(\App\Models\Kelas $kela)
    {
        $kelas = $kela; // Laravel parameter name matching
        $jurusans = \App\Models\Jurusan::all();
        return view('kelas.edit', compact('kelas', 'jurusans'));
    }

    public function update(Request $request, \App\Models\Kelas $kela)
    {
        $kelas = $kela;
        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|string|max:10',
        ]);

        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(\App\Models\Kelas $kela)
    {
        $kelas = $kela;
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
