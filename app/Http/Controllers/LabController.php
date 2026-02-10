<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labs = \App\Models\Lab::with('jurusan')->get();
        return view('lab.index', compact('labs'));
    }

    public function create()
    {
        $jurusans = \App\Models\Jurusan::all();
        return view('lab.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
        ]);

        \App\Models\Lab::create($request->all());

        return redirect()->route('labs.index')->with('success', 'Lab berhasil ditambahkan.');
    }

    public function show(\App\Models\Lab $lab)
    {
        return view('lab.show', compact('lab'));
    }

    public function edit(\App\Models\Lab $lab)
    {
        $jurusans = \App\Models\Jurusan::all();
        return view('lab.edit', compact('lab', 'jurusans'));
    }

    public function update(Request $request, \App\Models\Lab $lab)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
        ]);

        $lab->update($request->all());

        return redirect()->route('labs.index')->with('success', 'Lab berhasil diperbarui.');
    }

    public function destroy(\App\Models\Lab $lab)
    {
        $lab->delete();

        return redirect()->route('labs.index')->with('success', 'Lab berhasil dihapus.');
    }
}
