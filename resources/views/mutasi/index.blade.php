@extends('layouts.admin')

@section('title', 'Riwayat Mutasi Barang')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h3 class="text-lg font-semibold text-slate-800">Daftar Mutasi</h3>
        <a href="{{ route('mutasi.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Mutasi Baru
        </a>
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
                    <td class="px-4 py-4 text-center text-slate-500">{{ $loop->iteration }}</td>
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
</div>
@endsection
