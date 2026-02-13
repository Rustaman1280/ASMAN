@extends('layouts.admin')

@section('title', 'Detail Lab: ' . $lab->nama)

@section('content')
<div class="mb-6">
    <a href="{{ route('labs.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Kembali ke Daftar Lab
    </a>
</div>

{{-- Info Ruangan --}}
<div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6 shadow-sm">
    <div class="flex items-start justify-between">
        <div>
            <h3 class="text-xl font-bold text-slate-800">{{ $lab->nama }}</h3>
            <div class="flex items-center gap-4 mt-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                    {{ $lab->jurusan->nama ?? '-' }}
                </span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
    </div>
</div>

{{-- Statistik Ringkasan --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Unit</p>
        <p class="text-2xl font-bold text-slate-800 mt-1">{{ $lab->units->count() }}</p>
    </div>
    <div class="bg-white rounded-xl border border-emerald-100 p-4 shadow-sm">
        <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Baik</p>
        <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $lab->units->where('kondisi', 'baik')->count() }}</p>
    </div>
    <div class="bg-white rounded-xl border border-amber-100 p-4 shadow-sm">
        <p class="text-xs font-bold text-amber-500 uppercase tracking-wider">Rusak</p>
        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $lab->units->where('kondisi', 'rusak')->count() }}</p>
    </div>
    <div class="bg-white rounded-xl border border-rose-100 p-4 shadow-sm">
        <p class="text-xs font-bold text-rose-500 uppercase tracking-wider">Hilang</p>
        <p class="text-2xl font-bold text-rose-600 mt-1">{{ $lab->units->where('kondisi', 'hilang')->count() }}</p>
    </div>
</div>

{{-- Tabel Daftar Barang --}}
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Daftar Barang di Ruangan Ini</h4>
        <button onclick="document.getElementById('formTambahUnit').classList.toggle('hidden')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors flex items-center shadow-lg shadow-blue-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Barang
        </button>
    </div>

    {{-- Form Tambah Unit Inline --}}
    <div id="formTambahUnit" class="hidden border-b border-slate-200 bg-blue-50/50 p-6">
        <form action="{{ route('units.store') }}" method="POST">
            @csrf
            <input type="hidden" name="lokasi_type" value="lab">
            <input type="hidden" name="lokasi_id" value="{{ $lab->id }}">
            <input type="hidden" name="redirect_to" value="{{ route('labs.show', $lab) }}">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label for="barang_id" class="block text-xs font-semibold text-slate-600 mb-1">Barang</label>
                    <select name="barang_id" id="barang_id" class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }} ({{ $barang->kode_barang }})</option>
                        @endforeach
                    </select>
                    @error('barang_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="kode_unit" class="block text-xs font-semibold text-slate-600 mb-1">Kode Unit</label>
                    <input type="text" name="kode_unit" id="kode_unit" value="{{ old('kode_unit') }}" class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Contoh: UNIT-001" required>
                    @error('kode_unit') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="kondisi" class="block text-xs font-semibold text-slate-600 mb-1">Kondisi</label>
                    <select name="kondisi" id="kondisi" class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" required>
                        <option value="baik" {{ old('kondisi', 'baik') === 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ old('kondisi') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="hilang" {{ old('kondisi') === 'hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                    @error('kondisi') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="detail_unit" class="block text-xs font-semibold text-slate-600 mb-1">Detail (opsional)</label>
                    <input type="text" name="detail_unit" id="detail_unit" value="{{ old('detail_unit') }}" class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all placeholder:text-slate-400" placeholder="Keterangan...">
                    @error('detail_unit') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('formTambahUnit').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-white rounded-lg transition-all">Batal</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">Simpan</button>
            </div>
        </form>
    </div>

    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode Unit</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode Barang</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kondisi</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Detail</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($lab->units as $unit)
            <tr class="hover:bg-blue-50/50 transition-colors">
                <td class="px-6 py-4 text-sm text-slate-600">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">
                    <span class="text-sm font-mono font-semibold text-slate-800 bg-slate-100 px-2 py-1 rounded">{{ $unit->kode_unit }}</span>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $unit->barang->nama_barang ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="text-sm font-mono text-slate-500">{{ $unit->barang->kode_barang ?? '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    @if($unit->kondisi === 'baik')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Baik
                        </span>
                    @elseif($unit->kondisi === 'rusak')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>Rusak
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>Hilang
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-slate-500">{{ $unit->detail_unit ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">
                    Belum ada barang di lab ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($errors->any())
<script>document.getElementById('formTambahUnit').classList.remove('hidden');</script>
@endif
@endsection
