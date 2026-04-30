<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Jurusan;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->query('jenis');
        $user = auth()->user();

        $query = Ruangan::with('jurusan')->withCount('barangs');

        if ($jenis) {
            $query->where('jenis_ruangan', $jenis);
        }

        if ($user->isPjRuangan()) {
            $query->whereIn('id', $user->ruangans->pluck('id'));
        }

        $ruangans = $query->get();
        return view('ruangan.index', compact('ruangans', 'jenis'));
    }

    public function create(Request $request)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        $user = auth()->user();
        $jurusans = $user->isPjRuangan() 
            ? Jurusan::whereIn('id', $user->ruangans->pluck('jurusan_id')->filter()->unique())->get() 
            : Jurusan::all();

        $jenis = $request->query('jenis', '');

        return view('ruangan.create', compact('jurusans', 'jenis'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        $request->validate([
            'kategori' => 'required|string|max:255',
            'jenis_ruangan' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'tingkat' => 'nullable|string|max:50',
            'jurusan_id' => 'nullable|exists:jurusans,id',
        ]);

        if (auth()->user()->isPjRuangan() && $request->filled('jurusan_id') && !auth()->user()->ruangans->pluck('jurusan_id')->contains($request->jurusan_id)) {
            abort(403, 'Anda hanya dapat menambahkan ruangan untuk jurusan yang sudah ada di ruangan kelolaan Anda.');
        }

        $ruangan = Ruangan::create($request->all());

        if (auth()->user()->isPjRuangan()) {
            auth()->user()->ruangans()->attach($ruangan->id);
        }

        return redirect()->route('ruangans.index', ['jenis' => $request->jenis_ruangan])
                         ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function show(Ruangan $ruangan)
    {
        $ruangan->load('barangs.supplier', 'jurusan');
        return view('ruangan.show', compact('ruangan'));
    }

    public function edit(Ruangan $ruangan)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->isPjRuangan() && !auth()->user()->ruangans->contains($ruangan->id)) {
            abort(403);
        }

        $user = auth()->user();
        $jurusans = $user->isPjRuangan() 
            ? Jurusan::whereIn('id', $user->ruangans->pluck('jurusan_id')->filter()->unique())->get() 
            : Jurusan::all();

        return view('ruangan.edit', compact('ruangan', 'jurusans'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->isPjRuangan() && !auth()->user()->ruangans->contains($ruangan->id)) {
            abort(403);
        }

        $request->validate([
            'kategori' => 'required|string|max:255',
            'jenis_ruangan' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'tingkat' => 'nullable|string|max:50',
            'jurusan_id' => 'nullable|exists:jurusans,id',
        ]);

        if (auth()->user()->isPjRuangan() && $request->filled('jurusan_id') && !auth()->user()->ruangans->pluck('jurusan_id')->contains($request->jurusan_id)) {
            abort(403, 'Anda hanya dapat memindahkan ruangan ke jurusan yang ada di ruangan kelolaan Anda.');
        }

        $ruangan->update($request->all());

        return redirect()->route('ruangans.index', ['jenis' => $request->jenis_ruangan])
                         ->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->isPjRuangan() && !auth()->user()->ruangans->contains($ruangan->id)) {
            abort(403);
        }

        $jenis = $ruangan->jenis_ruangan;
        $ruangan->delete();

        return redirect()->route('ruangans.index', ['jenis' => $jenis])
                         ->with('success', 'Ruangan berhasil dihapus.');
    }
}
