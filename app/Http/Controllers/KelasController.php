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
        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $kelas = \App\Models\Kelas::with('jurusan')->where('jurusan_id', $user->jurusan_id)->get();
        }
        else {
            $kelas = \App\Models\Kelas::with('jurusan')->get();
        }
        return view('kelas.index', compact('kelas'));
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
        return view('kelas.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|string|max:10',
        ]);

        if (auth()->user()->role === 'guru_jurusan' && $request->jurusan_id != auth()->user()->jurusan_id) {
            abort(403, 'Anda hanya dapat menambahkan kelas untuk jurusan Anda sendiri.');
        }

        \App\Models\Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(\App\Models\Kelas $kelas)
    {
        $kelas->load('units.barang', 'jurusan');
        $barangs = \App\Models\Barang::all();
        return view('kelas.show', compact('kelas', 'barangs'));
    }

    public function edit(\App\Models\Kelas $kela)
    {
        $kelas = $kela;
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $kelas->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $jurusans = \App\Models\Jurusan::where('id', $user->jurusan_id)->get();
        }
        else {
            $jurusans = \App\Models\Jurusan::all();
        }

        return view('kelas.edit', compact('kelas', 'jurusans'));
    }

    public function update(Request $request, \App\Models\Kelas $kela)
    {
        $kelas = $kela;
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $kelas->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|string|max:10',
        ]);

        if (auth()->user()->role === 'guru_jurusan' && $request->jurusan_id != auth()->user()->jurusan_id) {
            abort(403, 'Anda hanya dapat memindahkan kelas ke jurusan Anda sendiri.');
        }

        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(\App\Models\Kelas $kela)
    {
        $kelas = $kela;
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $kelas->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
