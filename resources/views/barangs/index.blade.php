@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-slate-800">Daftar Barang</h3>
        <a href="{{ route('barangs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Barang
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 font-semibold uppercase tracking-wider border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Nama Barang</th>
                    <th class="px-6 py-4">Stock</th>
                    <th class="px-6 py-4">Jumlah Unit</th>
                    <th class="px-6 py-4">Supplier</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($barangs as $barang)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs font-semibold text-slate-500">{{ $barang->kode_barang }}</td>
                    <td class="px-6 py-4 font-medium text-slate-900">{{ $barang->nama_barang }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $barang->stock_barang > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $barang->stock_barang }} unit
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('barangs.show', $barang) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                            {{ $barang->units_count }} unit terdaftar
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                    <td class="px-6 py-4">{{ $barang->supplier->nama_supplier ?? '-' }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('barangs.show', $barang) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs font-medium">Detail</a>
                        <a href="{{ route('barangs.edit', $barang) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors text-xs font-medium">Edit</a>
                        <form action="{{ route('barangs.destroy', $barang) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-xs font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data barang.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
