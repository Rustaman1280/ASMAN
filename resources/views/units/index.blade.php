@extends('layouts.admin')

@section('title', 'Unit Aset')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-slate-800">Daftar Unit Aset</h3>
        <a href="{{ route('units.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Unit
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 font-semibold uppercase tracking-wider border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Kode Unit</th>
                    <th class="px-6 py-4">Nama Barang</th>
                    <th class="px-6 py-4">Lokasi</th>
                    <th class="px-6 py-4">Kondisi</th>
                    <th class="px-6 py-4">Detail</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($units as $unit)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs font-semibold text-slate-500">{{ $unit->kode_unit }}</td>
                    <td class="px-6 py-4 font-medium text-slate-900">
                        {{ $unit->barang->nama_barang ?? '-' }}
                        <span class="text-xs text-slate-400 block">{{ $unit->barang->kode_barang ?? '' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($unit->lokasi)
                            <span class="font-medium text-slate-700">{{ $unit->lokasi->nama }}</span>
                            <span class="text-xs text-slate-400 block">{{ class_basename($unit->lokasi_type) }}</span>
                        @else
                            <span class="text-slate-400 italic">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($unit->kondisi === 'baik')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Baik</span>
                        @elseif($unit->kondisi === 'rusak')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Rusak</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Hilang</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($unit->detail_unit)
                            <p class="text-xs text-slate-500 truncate max-w-xs">{{ $unit->detail_unit }}</p>
                        @else
                            <span class="text-slate-400 italic text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('units.edit', $unit) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors text-xs font-medium">Edit</a>
                        <form action="{{ route('units.destroy', $unit) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-xs font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data unit.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
