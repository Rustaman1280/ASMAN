@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center">
        <a href="{{ route('barangs.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h3 class="text-lg font-semibold text-slate-700">Edit Data Barang</h3>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm p-8">
        <form action="{{ route('barangs.update', $barang) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kode_barang" class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                        <input type="text" name="kode_barang" id="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Contoh: BRG-001" required>
                        @error('kode_barang') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="nama_barang" class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Contoh: Laptop Asus" required>
                        @error('nama_barang') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="stock_barang" class="block text-sm font-semibold text-slate-700 mb-2">Stock Total</label>
                        <input type="number" name="stock_barang" id="stock_barang" min="0" value="{{ old('stock_barang', $barang->stock_barang) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Jumlah total barang" required>
                        @error('stock_barang') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="supplier_id" class="block text-sm font-semibold text-slate-700 mb-2">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $barang->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id') <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                    <a href="{{ route('barangs.index') }}" class="px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-all">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
