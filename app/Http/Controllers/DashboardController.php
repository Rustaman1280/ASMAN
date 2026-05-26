<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Ruangan;
use App\Models\Barang;
use App\Models\Mutasi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Total Jurusan & Ruangan
        if ($user->isPjRuangan()) {
            $totalJurusan = Jurusan::whereIn('id', $user->ruangans->pluck('jurusan_id')->filter()->unique())->count();
            $totalRuangan = $user->ruangans()->count();
        } else {
            $totalJurusan = Jurusan::count();
            $totalRuangan = Ruangan::count();
        }

        // 2. Total Barang & Kondisi
        $barangsQuery = Barang::query();
        if ($user->isPjRuangan()) {
            $barangsQuery->whereHas('ruangans', function ($q) use ($user) {
                $q->whereIn('ruangans.id', $user->ruangans->pluck('id'));
            });
        }
        
        // Sum total quantities
        $totalBaik = $barangsQuery->sum('jumlah_baik');
        $totalRusakRingan = $barangsQuery->sum('jumlah_rusak_ringan');
        $totalRusakBerat = $barangsQuery->sum('jumlah_rusak_berat');
        $totalBarang = $totalBaik + $totalRusakRingan + $totalRusakBerat;

        // 3. Mutasi Terbaru
        $mutasiQuery = Mutasi::with(['barang', 'unitBarang', 'user'])->latest();
        if ($user->isPjRuangan()) {
            $mutasiQuery->where(function ($q) use ($user) {
                $q->whereHas('ruanganAwal', function ($sq) use ($user) {
                    $sq->whereIn('ruangans.id', $user->ruangans->pluck('id'));
                })->orWhereHas('ruanganAkhir', function ($sq) use ($user) {
                    $sq->whereIn('ruangans.id', $user->ruangans->pluck('id'));
                })->orWhereHas('unitBarang.ruangan', function ($sq) use ($user) {
                    $sq->whereIn('ruangans.id', $user->ruangans->pluck('id'));
                })->orWhereHas('barang.ruangans', function ($sq) use ($user) {
                    $sq->whereIn('ruangans.id', $user->ruangans->pluck('id'));
                });
            });
        }
        $recentMutasi = $mutasiQuery->take(5)->get();
        $totalMutasi = $mutasiQuery->count();

        return view('dashboard', compact(
            'totalJurusan',
            'totalRuangan',
            'totalBarang',
            'totalBaik',
            'totalRusakRingan',
            'totalRusakBerat',
            'totalMutasi',
            'recentMutasi'
        ));
    }
}
