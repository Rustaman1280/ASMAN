@extends('layouts.admin')

@section('title', 'Detail Barang - ' . $barang->nama_barang)

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center">
        <a href="{{ route('barangs.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h3 class="text-lg font-semibold text-slate-700">Detail Barang</h3>
    </div>

    {{-- Info Barang --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kode Barang</p>
                <p class="font-mono text-sm font-semibold text-slate-700">{{ $barang->kode_barang }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Barang</p>
                <p class="text-sm font-semibold text-slate-900">{{ $barang->nama_barang }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Stock Total</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $barang->stock_barang > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $barang->stock_barang }} unit
                </span>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Supplier</p>
                <p class="text-sm text-slate-700">{{ $barang->supplier->nama_supplier ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Daftar Unit --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-slate-800">
                Unit-unit dari {{ $barang->nama_barang }}
                <span class="text-sm font-normal text-slate-400 ml-2">({{ $barang->units->count() }} unit)</span>
            </h3>
            <a href="{{ route('units.create') }}?barang_id={{ $barang->id }}" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors flex items-center text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Unit
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-semibold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Kode Unit</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Kondisi</th>
                        <th class="px-6 py-4">Detail</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barang->units as $unit)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs font-semibold text-slate-500">{{ $unit->kode_unit }}</td>
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
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 italic">Belum ada unit untuk barang ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
