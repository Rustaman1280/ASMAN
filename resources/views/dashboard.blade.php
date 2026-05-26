@extends('layouts.admin')

@section('title', 'Beranda')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="relative bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-8 sm:p-10 text-white overflow-hidden shadow-xl shadow-blue-900/20">
        <div class="relative z-10 md:w-2/3">
            <h2 class="text-3xl font-bold mb-3 tracking-tight">Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
            <p class="text-blue-100 text-lg max-w-xl mb-6">Kelola data inventaris dan akademik sekolah dengan lebih mudah, cepat, dan rapi dalam satu sistem terintegrasi.</p>
            <div class="flex gap-3">
                <a href="{{ route('barangs.create') }}" class="px-5 py-2.5 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-sm text-sm">
                    + Tambah Barang
                </a>
                <a href="{{ route('mutasi.create') }}" class="px-5 py-2.5 bg-blue-800/50 text-white font-semibold rounded-xl hover:bg-blue-800 transition-colors border border-blue-500/30 backdrop-blur-sm text-sm">
                    Catat Mutasi
                </a>
            </div>
        </div>
        
        <!-- Decorative Background -->
        <div class="absolute right-0 top-0 bottom-0 w-1/3 pointer-events-none hidden md:block">
            <div class="absolute inset-0 bg-gradient-to-l from-transparent to-blue-600/20"></div>
            <svg class="absolute right-[-10%] top-[-20%] h-[140%] text-white/10 transform rotate-12" viewBox="0 0 200 200" fill="currentColor">
                <path d="M100 0C44.7715 0 0 44.7715 0 100C0 155.228 44.7715 200 100 200C155.228 200 200 155.228 200 100C200 44.7715 155.228 0 100 0ZM100 160C66.8629 160 40 133.137 40 100C40 66.8629 66.8629 40 100 40C133.137 40 160 66.8629 160 100C160 133.137 133.137 160 100 160Z"/>
            </svg>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat: Jurusan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m0 10h1m-1 4h1m-7 10v-2a2 2 0 012-2h12a2 2 0 012 2v2"></path></svg>
                </div>
                <a href="{{ route('jurusans.index') }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Jurusan</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalJurusan) }}</h3>
            </div>
        </div>

        <!-- Stat: Ruangan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m0 10h1m-1 4h1m-7 10v-2a2 2 0 012-2h12a2 2 0 012 2v2"></path></svg>
                </div>
                <a href="{{ route('ruangans.index') }}" class="p-1.5 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Ruangan</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalRuangan) }}</h3>
            </div>
        </div>

        <!-- Stat: Barang -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <a href="{{ route('barangs.index') }}" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Unit Barang</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalBarang) }}</h3>
            </div>
        </div>

        <!-- Stat: Mutasi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
                <a href="{{ route('mutasi.index') }}" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Mutasi</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalMutasi) }}</h3>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Condition & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kondisi Barang Overview -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm lg:col-span-1 flex flex-col">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Status Kondisi Barang</h3>
                <p class="text-xs text-slate-500 mt-1">Ringkasan kondisi fisik seluruh unit.</p>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-center space-y-6">
                @php
                    $baikPct = $totalBarang > 0 ? round(($totalBaik / $totalBarang) * 100) : 0;
                    $rrPct = $totalBarang > 0 ? round(($totalRusakRingan / $totalBarang) * 100) : 0;
                    $rbPct = $totalBarang > 0 ? round(($totalRusakBerat / $totalBarang) * 100) : 0;
                @endphp
                
                <!-- Baik -->
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <span class="text-sm font-bold text-slate-700 block">Baik</span>
                            <span class="text-xs font-medium text-slate-500">{{ number_format($totalBaik) }} Unit</span>
                        </div>
                        <span class="text-sm font-bold text-emerald-600">{{ $baikPct }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-emerald-500 h-2.5 rounded-full" style="width: {{ $baikPct }}%"></div>
                    </div>
                </div>

                <!-- Rusak Ringan -->
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <span class="text-sm font-bold text-slate-700 block">Rusak Ringan</span>
                            <span class="text-xs font-medium text-slate-500">{{ number_format($totalRusakRingan) }} Unit</span>
                        </div>
                        <span class="text-sm font-bold text-amber-500">{{ $rrPct }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-amber-400 h-2.5 rounded-full" style="width: {{ $rrPct }}%"></div>
                    </div>
                </div>

                <!-- Rusak Berat -->
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <span class="text-sm font-bold text-slate-700 block">Rusak Berat</span>
                            <span class="text-xs font-medium text-slate-500">{{ number_format($totalRusakBerat) }} Unit</span>
                        </div>
                        <span class="text-sm font-bold text-rose-500">{{ $rbPct }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-rose-500 h-2.5 rounded-full" style="width: {{ $rbPct }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm lg:col-span-2 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Aktivitas Mutasi Terbaru</h3>
                    <p class="text-xs text-slate-500 mt-1">Pergerakan dan perubahan data terakhir.</p>
                </div>
                <a href="{{ route('mutasi.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Barang / Unit</th>
                            <th class="px-6 py-4">Jenis Mutasi</th>
                            <th class="px-6 py-4">User</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentMutasi as $mutasi)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-medium">
                                {{ \Carbon\Carbon::parse($mutasi->tanggal_mutasi)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">{{ $mutasi->barang->nama_barang ?? 'Barang Terhapus' }}</p>
                                @if($mutasi->unitBarang)
                                    <p class="text-xs text-slate-500 font-mono mt-0.5">{{ $mutasi->unitBarang->kode_unit }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badges = [
                                        'penambahan' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'ubah_status' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'ubah_lokasi' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'peminjaman' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'pengembalian' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                        'penghapusan' => 'bg-rose-100 text-rose-800 border-rose-200',
                                    ];
                                    $badge = $badges[$mutasi->jenis_mutasi] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                    $label = ucwords(str_replace('_', ' ', $mutasi->jenis_mutasi));
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badge }}">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600 mr-2">
                                        {{ substr($mutasi->user->name ?? 'U', 0, 2) }}
                                    </div>
                                    {{ explode(' ', $mutasi->user->name ?? 'System')[0] }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    <p class="font-medium text-sm">Belum ada aktivitas mutasi.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
