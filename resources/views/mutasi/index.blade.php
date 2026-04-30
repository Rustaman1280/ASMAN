@extends('layouts.admin')

@section('title', 'Riwayat Mutasi Barang')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h3 class="text-lg font-semibold text-slate-800">Daftar Mutasi</h3>
        <div class="flex items-center gap-3">
            <a href="{{ route('mutasi.export', request()->query()) }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors text-sm font-medium shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Excel
            </a>
            <a href="{{ route('mutasi.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Mutasi Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
        <form action="{{ route('mutasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-7 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tampilkan</label>
                <div class="relative">
                    <input type="number" name="per_page" value="{{ request('per_page', 15) }}" min="1" max="1000" class="w-full pl-4 pr-10 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" title="Jumlah Baris">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400 pointer-events-none">Baris</span>
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Cari Barang / Keterangan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Admin / Pencatat</label>
                <select name="user_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                    <option value="">Semua Admin</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ request('user_id') == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Mutasi</label>
                <select name="jenis_mutasi" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                    <option value="">Semua Jenis</option>
                    <option value="penambahan" {{ request('jenis_mutasi') === 'penambahan' ? 'selected' : '' }}>Penambahan</option>
                    <option value="ubah_status" {{ request('jenis_mutasi') === 'ubah_status' ? 'selected' : '' }}>Ubah Status</option>
                    <option value="ubah_lokasi" {{ request('jenis_mutasi') === 'ubah_lokasi' ? 'selected' : '' }}>Ubah Lokasi</option>
                    <option value="peminjaman" {{ request('jenis_mutasi') === 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                    <option value="pengembalian" {{ request('jenis_mutasi') === 'pengembalian' ? 'selected' : '' }}>Pengembalian</option>
                    <option value="penghapusan" {{ request('jenis_mutasi') === 'penghapusan' ? 'selected' : '' }}>Penghapusan</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Mulai Tanggal</label>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
            </div>
            <div class="flex items-center gap-2">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Sampai</label>
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                </div>
                <button type="submit" class="mt-5 px-4 py-2 bg-slate-800 text-white rounded-xl hover:bg-slate-900 transition-colors text-sm font-medium">Filter</button>
                @if(request()->anyFilled(['search', 'jenis_mutasi', 'tanggal_mulai', 'tanggal_akhir', 'user_id']))
                    <a href="{{ route('mutasi.index', ['per_page' => request('per_page')]) }}" class="mt-5 px-3 py-2 bg-slate-200 text-slate-600 rounded-xl hover:bg-slate-300 transition-colors text-sm font-medium" title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 font-semibold uppercase tracking-wider border-b border-slate-200">
                <tr>
                    <th class="px-4 py-4 text-center">No</th>
                    <th class="px-4 py-4">Tanggal</th>
                    <th class="px-4 py-4">Jenis Mutasi</th>
                    <th class="px-4 py-4">Barang / Unit</th>
                    <th class="px-4 py-4">Detail Perubahan</th>
                    <th class="px-4 py-4">Keterangan</th>
                    <th class="px-4 py-4">Admin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($mutasis as $mutasi)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-4 text-center text-slate-500">{{ $mutasis->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-4 font-medium text-slate-900 whitespace-nowrap">{{ \Carbon\Carbon::parse($mutasi->tanggal_mutasi)->format('d M Y') }}</td>
                    <td class="px-4 py-4">
                        @php
                            $badgeColors = [
                                'penambahan' => 'bg-emerald-100 text-emerald-700',
                                'ubah_status' => 'bg-amber-100 text-amber-700',
                                'ubah_lokasi' => 'bg-blue-100 text-blue-700',
                                'peminjaman' => 'bg-purple-100 text-purple-700',
                                'pengembalian' => 'bg-indigo-100 text-indigo-700',
                                'penghapusan' => 'bg-rose-100 text-rose-700',
                            ];
                            $color = $badgeColors[$mutasi->jenis_mutasi] ?? 'bg-slate-100 text-slate-700';
                            $label = str_replace('_', ' ', $mutasi->jenis_mutasi);
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold uppercase tracking-wider {{ $color }}">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="font-medium text-slate-800">{{ $mutasi->barang->nama_barang ?? '-' }}</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $mutasi->unitBarang->kode_unit ?? '-' }}</div>
                    </td>
                    <td class="px-4 py-4 text-sm">
                        @if($mutasi->jenis_mutasi === 'ubah_status')
                            <span class="text-slate-500 line-through">{{ $mutasi->status_awal }}</span> &rarr; <span class="font-semibold text-amber-600">{{ $mutasi->status_akhir }}</span>
                        @elseif($mutasi->jenis_mutasi === 'ubah_lokasi')
                            <span class="text-slate-500 line-through">{{ $mutasi->ruanganAwal->nama ?? '-' }}</span> &rarr; <span class="font-semibold text-blue-600">{{ $mutasi->ruanganAkhir->nama ?? '-' }}</span>
                        @elseif($mutasi->jenis_mutasi === 'peminjaman')
                            Peminjam: <span class="font-semibold text-slate-800">{{ $mutasi->nama_peminjam }}</span><br>
                            Jatuh Tempo: <span class="text-rose-600">{{ \Carbon\Carbon::parse($mutasi->tanggal_kembali)->format('d/m/Y') }}</span>
                        @elseif($mutasi->jenis_mutasi === 'penambahan')
                            Status: <span class="font-semibold text-emerald-600">{{ $mutasi->status_akhir }}</span><br>
                            Lokasi: <span class="font-semibold text-slate-700">{{ $mutasi->ruanganAkhir->nama ?? '-' }}</span>
                        @elseif($mutasi->jenis_mutasi === 'penghapusan')
                            Dihapus dari <span class="font-semibold">{{ $mutasi->ruanganAwal->nama ?? '-' }}</span> ({{ $mutasi->status_awal }})
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-4 text-slate-500 max-w-[200px] truncate">{{ $mutasi->keterangan ?? '-' }}</td>
                    <td class="px-4 py-4 text-slate-500">{{ $mutasi->user->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-400 italic">Belum ada riwayat mutasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($mutasis->hasPages())
    <div class="p-4 border-t border-slate-100 overflow-x-auto">
        {{ $mutasis->onEachSide(1)->links() }}
    </div>
    @endif
</div>
@endsection
