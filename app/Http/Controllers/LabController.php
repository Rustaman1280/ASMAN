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
        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $labs = \App\Models\Lab::with('jurusan')->where('jurusan_id', $user->jurusan_id)->get();
        }
        else {
            $labs = \App\Models\Lab::with('jurusan')->get();
        }
        return view('lab.index', compact('labs'));
    }

    public function create()
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $jurusans = \App\Models\Jurusan::where('id', $user->jurusan_id)->get();
        }
        else {
            $jurusans = \App\Models\Jurusan::all();
        }
        return view('lab.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
        ]);

        if (auth()->user()->role === 'guru_jurusan' && $request->jurusan_id != auth()->user()->jurusan_id) {
            abort(403, 'Anda hanya dapat menambahkan lab untuk jurusan Anda sendiri.');
        }

        \App\Models\Lab::create($request->all());

        return redirect()->route('labs.index')->with('success', 'Lab berhasil ditambahkan.');
    }

    public function show(\App\Models\Lab $lab)
    {
        return view('lab.show', compact('lab'));
    }

    public function edit(\App\Models\Lab $lab)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $lab->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $jurusans = \App\Models\Jurusan::where('id', $user->jurusan_id)->get();
        }
        else {
            $jurusans = \App\Models\Jurusan::all();
        }

        return view('lab.edit', compact('lab', 'jurusans'));
    }

    public function update(Request $request, \App\Models\Lab $lab)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $lab->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
        ]);

        if (auth()->user()->role === 'guru_jurusan' && $request->jurusan_id != auth()->user()->jurusan_id) {
            abort(403, 'Anda hanya dapat memindahkan lab ke jurusan Anda sendiri.');
        }

        $lab->update($request->all());

        return redirect()->route('labs.index')->with('success', 'Lab berhasil diperbarui.');
    }

    public function destroy(\App\Models\Lab $lab)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $lab->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $lab->delete();

        return redirect()->route('labs.index')->with('success', 'Lab berhasil dihapus.');
    }
}
