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
        $user = auth()->user();

        if ($user->role === 'guru_jurusan') {
            $jurusans = \App\Models\Jurusan::where('id', $user->jurusan_id)->get();
        }
        else {
            $jurusans = \App\Models\Jurusan::all();
        }

        return view('jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        if (!auth()->user()->canEdit()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah data.');
        }
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

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
        if (!auth()->user()->canEdit()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah data.');
        }

        // Guru jurusan hanya bisa edit jurusannya sendiri
        if (auth()->user()->role === 'guru_jurusan' && auth()->user()->jurusan_id !== $jurusan->id) {
            abort(403, 'Anda hanya dapat mengubah data jurusan Anda sendiri.');
        }

        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, \App\Models\Jurusan $jurusan)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && auth()->user()->jurusan_id !== $jurusan->id) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:20|unique:jurusans,kode,' . $jurusan->id,
        ]);

        $jurusan->update($request->all());

        return redirect()->route('jurusans.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(\App\Models\Jurusan $jurusan)
    {
        if (!auth()->user()->canEdit()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus data.');
        }

        if (auth()->user()->role === 'guru_jurusan' && auth()->user()->jurusan_id !== $jurusan->id) {
            abort(403);
        }

        $jurusan->delete();

        return redirect()->route('jurusans.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
