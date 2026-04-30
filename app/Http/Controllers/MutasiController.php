<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutasi;
use App\Models\Barang;
use App\Models\UnitBarang;
use App\Models\Ruangan;

class MutasiController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = Mutasi::with(['barang', 'unitBarang', 'user', 'ruanganAwal', 'ruanganAkhir'])->latest();
        $user = auth()->user();

        if ($user && $user->isPjRuangan()) {
            $query->where(function ($q) use ($user) {
                $q->whereHas('ruanganAwal', function ($sq) use ($user) {
                    $sq->whereIn('id', $user->ruangans->pluck('id'));
                })->orWhereHas('ruanganAkhir', function ($sq) use ($user) {
                    $sq->whereIn('id', $user->ruangans->pluck('id'));
                })->orWhereHas('unitBarang.ruangan', function ($sq) use ($user) {
                    $sq->whereIn('id', $user->ruangans->pluck('id'));
                })->orWhereHas('barang.ruangans', function ($sq) use ($user) {
                    $sq->whereIn('id', $user->ruangans->pluck('id'));
                });
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('barang', function ($sq) use ($search) {
                    $sq->where('nama_barang', 'like', "%{$search}%")
                       ->orWhere('kode_barang', 'like', "%{$search}%");
                })->orWhereHas('unitBarang', function ($sq) use ($search) {
                    $sq->where('kode_unit', 'like', "%{$search}%");
                })->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhere('nama_peminjam', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_mutasi')) {
            $query->where('jenis_mutasi', $request->jenis_mutasi);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_mutasi', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_mutasi', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->buildQuery($request);
        $perPage = $request->get('per_page', 15);
        $mutasis = $query->paginate($perPage)->withQueryString();
        $admins = \App\Models\User::orderBy('name')->get();
        return view('mutasi.index', compact('mutasis', 'admins'));
    }

    public function export(Request $request)
    {
        $query = $this->buildQuery($request);
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MutasiExport($query), 'data-mutasi-' . date('Y-m-d') . '.xlsx');
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        
        $barangsQuery = Barang::query();
        $unitBarangsQuery = UnitBarang::with(['barang', 'ruangan']);
        $ruangansQuery = Ruangan::query();

        if ($user && $user->isPjRuangan()) {
            $ruangansQuery->whereIn('id', $user->ruangans->pluck('id'));
            $barangsQuery->whereHas('ruangans', function ($q) use ($user) {
                $q->whereIn('id', $user->ruangans->pluck('id'));
            });
            $unitBarangsQuery->whereHas('ruangan', function ($q) use ($user) {
                $q->whereIn('id', $user->ruangans->pluck('id'));
            });
        }

        $barangs = $barangsQuery->get();
        $unitBarangs = $unitBarangsQuery->get();
        $ruangans = $ruangansQuery->get();
        $preselectedUnitId = $request->query('unit_id');
        $preselectedJenis = $request->query('jenis');

        return view('mutasi.create', compact('barangs', 'unitBarangs', 'ruangans', 'preselectedUnitId', 'preselectedJenis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_mutasi' => 'required|in:penambahan,ubah_status,ubah_lokasi,peminjaman,pengembalian,penghapusan',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable|string',
            'barang_id' => 'required_if:jenis_mutasi,penambahan|nullable|exists:barangs,id',
            'unit_barang_id' => 'required_unless:jenis_mutasi,penambahan|nullable|exists:unit_barangs,id',
            'kondisi' => 'required_if:jenis_mutasi,penambahan|nullable|in:baik,rusak_ringan,rusak_berat',
            'ruangan_id' => 'required_if:jenis_mutasi,penambahan|nullable|exists:ruangans,id',
            'status_akhir' => 'required_if:jenis_mutasi,ubah_status|nullable|in:baik,rusak_ringan,rusak_berat',
            'ruangan_akhir_id' => 'required_if:jenis_mutasi,ubah_lokasi|nullable|exists:ruangans,id',
            'nama_peminjam' => 'required_if:jenis_mutasi,peminjaman|nullable|string|max:255',
            'tanggal_kembali' => 'nullable|date',
            'jumlah_unit' => 'required_if:jenis_mutasi,penambahan|nullable|integer|min:1',
        ]);

        $jenis = $request->jenis_mutasi;

        if ($jenis === 'penambahan') {
            $barang = Barang::findOrFail($request->barang_id);
            $jumlahUnit = max(1, (int) $request->input('jumlah_unit', 1));
            
            for ($i = 0; $i < $jumlahUnit; $i++) {
                $count = \App\Models\UnitBarang::where('barang_id', $barang->id)->count();
                $kodeUnit = $barang->kode_barang . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
                
                $unit = UnitBarang::create([
                    'barang_id' => $barang->id,
                    'kode_unit' => $kodeUnit,
                    'kondisi' => $request->kondisi,
                    'ruangan_id' => $request->ruangan_id
                ]);

                Mutasi::create([
                    'barang_id' => $barang->id,
                    'unit_barang_id' => $unit->id,
                    'user_id' => auth()->id(),
                    'jenis_mutasi' => 'penambahan',
                    'keterangan' => $request->keterangan,
                    'tanggal_mutasi' => $request->tanggal_mutasi,
                    'status_akhir' => $request->kondisi,
                    'ruangan_akhir_id' => $request->ruangan_id,
                ]);
            }

            $col = 'jumlah_' . $request->kondisi;
            $barang->$col += $jumlahUnit;
            $barang->save();

            if ($request->ruangan_id) {
                $pivot = $barang->ruangans()->where('ruangan_id', $request->ruangan_id)->first();
                if ($pivot) {
                    $barang->ruangans()->updateExistingPivot($request->ruangan_id, ['jumlah' => $pivot->pivot->jumlah + $jumlahUnit]);
                } else {
                    $barang->ruangans()->attach($request->ruangan_id, ['jumlah' => $jumlahUnit]);
                }
            }

            return redirect()->route('mutasi.index')->with('success', "Berhasil menambahkan {$jumlahUnit} unit barang baru.");
        }

        $unit = UnitBarang::findOrFail($request->unit_barang_id);
        $barang = $unit->barang;

        if ($jenis === 'ubah_status') {
            $oldStatus = $unit->kondisi;
            $newStatus = $request->status_akhir;
            
            if ($oldStatus !== $newStatus) {
                $unit->kondisi = $newStatus;
                $unit->save();

                $oldCol = 'jumlah_' . $oldStatus;
                $newCol = 'jumlah_' . $newStatus;
                if ($barang->$oldCol > 0) $barang->$oldCol -= 1;
                $barang->$newCol += 1;
                $barang->save();

                Mutasi::create([
                    'barang_id' => $barang->id,
                    'unit_barang_id' => $unit->id,
                    'user_id' => auth()->id(),
                    'jenis_mutasi' => 'ubah_status',
                    'keterangan' => $request->keterangan,
                    'tanggal_mutasi' => $request->tanggal_mutasi,
                    'status_awal' => $oldStatus,
                    'status_akhir' => $newStatus,
                ]);
            }
            return redirect()->route('mutasi.index')->with('success', 'Status unit barang berhasil diubah.');
        }

        if ($jenis === 'ubah_lokasi') {
            $oldLocation = $unit->ruangan_id;
            $newLocation = $request->ruangan_akhir_id;
            
            if ($oldLocation != $newLocation) {
                $unit->ruangan_id = $newLocation;
                $unit->save();

                if ($oldLocation) {
                    $oldPivot = $barang->ruangans()->where('ruangan_id', $oldLocation)->first();
                    if ($oldPivot) {
                        $newJumlah = $oldPivot->pivot->jumlah - 1;
                        if ($newJumlah <= 0) {
                            $barang->ruangans()->detach($oldLocation);
                        } else {
                            $barang->ruangans()->updateExistingPivot($oldLocation, ['jumlah' => $newJumlah]);
                        }
                    }
                }
                if ($newLocation) {
                    $newPivot = $barang->ruangans()->where('ruangan_id', $newLocation)->first();
                    if ($newPivot) {
                        $barang->ruangans()->updateExistingPivot($newLocation, ['jumlah' => $newPivot->pivot->jumlah + 1]);
                    } else {
                        $barang->ruangans()->attach($newLocation, ['jumlah' => 1]);
                    }
                }

                Mutasi::create([
                    'barang_id' => $barang->id,
                    'unit_barang_id' => $unit->id,
                    'user_id' => auth()->id(),
                    'jenis_mutasi' => 'ubah_lokasi',
                    'keterangan' => $request->keterangan,
                    'tanggal_mutasi' => $request->tanggal_mutasi,
                    'ruangan_awal_id' => $oldLocation,
                    'ruangan_akhir_id' => $newLocation,
                ]);
            }
            return redirect()->route('mutasi.index')->with('success', 'Lokasi unit barang berhasil diubah.');
        }

        if ($jenis === 'peminjaman') {
            Mutasi::create([
                'barang_id' => $barang->id,
                'unit_barang_id' => $unit->id,
                'user_id' => auth()->id(),
                'jenis_mutasi' => 'peminjaman',
                'keterangan' => $request->keterangan,
                'tanggal_mutasi' => $request->tanggal_mutasi,
                'nama_peminjam' => $request->nama_peminjam,
                'tanggal_kembali' => $request->tanggal_kembali,
            ]);
            return redirect()->route('mutasi.index')->with('success', 'Peminjaman barang berhasil dicatat.');
        }

        if ($jenis === 'pengembalian') {
            Mutasi::create([
                'barang_id' => $barang->id,
                'unit_barang_id' => $unit->id,
                'user_id' => auth()->id(),
                'jenis_mutasi' => 'pengembalian',
                'keterangan' => $request->keterangan,
                'tanggal_mutasi' => $request->tanggal_mutasi,
            ]);
            return redirect()->route('mutasi.index')->with('success', 'Pengembalian barang berhasil dicatat.');
        }

        if ($jenis === 'penghapusan') {
            $status = $unit->kondisi;
            $ruangan = $unit->ruangan_id;

            $unit->delete();

            $col = 'jumlah_' . $status;
            if ($barang->$col > 0) $barang->$col -= 1;
            $barang->save();

            if ($ruangan) {
                $pivot = $barang->ruangans()->where('ruangan_id', $ruangan)->first();
                if ($pivot) {
                    $newJumlah = $pivot->pivot->jumlah - 1;
                    if ($newJumlah <= 0) {
                        $barang->ruangans()->detach($ruangan);
                    } else {
                        $barang->ruangans()->updateExistingPivot($ruangan, ['jumlah' => $newJumlah]);
                    }
                }
            }

            Mutasi::create([
                'barang_id' => $barang->id,
                'unit_barang_id' => null, 
                'user_id' => auth()->id(),
                'jenis_mutasi' => 'penghapusan',
                'keterangan' => $request->keterangan,
                'tanggal_mutasi' => $request->tanggal_mutasi,
                'status_awal' => $status,
                'ruangan_awal_id' => $ruangan,
            ]);
            return redirect()->route('mutasi.index')->with('success', 'Unit barang berhasil dihapus dari sistem.');
        }

        return back();
    }
}
