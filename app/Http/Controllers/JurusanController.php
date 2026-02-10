<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusans = \App\Models\Jurusan::all();
        return view('jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:20|unique:jurusans',
        ]);

        \App\Models\Jurusan::create($request->all());

        return redirect()->route('jurusans.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function show(\App\Models\Jurusan $jurusan)
    {
        return view('jurusan.show', compact('jurusan'));
    }

    public function edit(\App\Models\Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, \App\Models\Jurusan $jurusan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:20|unique:jurusans,kode,' . $jurusan->id,
        ]);

        $jurusan->update($request->all());

        return redirect()->route('jurusans.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(\App\Models\Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('jurusans.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
